<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Admin\Node;
use Illuminate\Http\Request;
use libraries\Tree;

class NodeController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $NodeDB = new Node();
        $Node = $NodeDB->getAllNode()->toArray();
        $array = array();
        // 构建生成树中所需的数据
        foreach($Node as $k => $r) {
            $r['id']      = $r['id'];
            $r['title']   = $r['title'];
            $r['name']    = $r['name'];
            $r['status']  = $r['status']==1 ? '<font color="red">√</font>' :'<font color="blue">×</font>';
            $r['submenu'] = $r['level']==3 ? '<font color="#cccccc">添加子菜单</font>' : "<a href='".url('/admin/node/add/'.$r['id'])."'>添加子菜单</a>";
            $r['edit']    = $r['level']==1 ? '<font color="#cccccc">修改</font>' : "<a href='".url('/admin/node/edit/'.$r['id'].'/'.$r['pid'])."'>修改</a>";
            $r['del']     = $r['level']==1 ? '<font color="#cccccc">删除</font>' : "<a onClick='return confirmurl(\"".url('/admin/node/del/'.$r['id'])."\",\"确定删除该菜单吗?\",true)' href='javascript:void(0)'>删除</a>";
            switch ($r['display']) {
                case 0:
                    $r['display'] = '不显示';
                    break;
                case 1:
                    $r['display'] = '主菜单';
                    break;
                case 2:
                    $r['display'] = '子菜单';
                    break;
            }
            switch ($r['level']) {
                case 0:
                    $r['level'] = '非节点';
                    break;
                case 1:
                    $r['level'] = '应用';
                    break;
                case 2:
                    $r['level'] = '模块';
                    break;
                case 3:
                    $r['level'] = '方法';
                    break;
            }
            $array[]      = $r;
        }

        $str  = "<tr class='tr'>
				    <td align='center'><input type='text' value='\$sort' size='3' name='sort[\$id]'></td>
				    <td align='center'>\$id</td> 
				    <td >\$spacer \$title (\$name)</td> 
				    <td align='center'>\$level</td> 
				    <td align='center'>\$status</td> 
				    <td align='center'>\$display</td> 
					<td align='center'>
						\$submenu | \$edit | \$del
					</td>
				  </tr>";

        $Tree = new Tree();
        $Tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $Tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $Tree->init($array);
        $html_tree = $Tree->get_tree(0, $str);

        return view('admin.node_index',['html_tree' => $html_tree]);
    }

    //添加菜单
    public function add(Request $request ,$pid=0)
    {
        $NodeDB = new Node();

        if(isset($_POST['dosubmit'])) {
            $data = $request->all();
            //控制器验证
            $this->validate($request, $NodeDB->getRules(),$NodeDB->getMessages());

            if($NodeDB->create($data)) {
                $this->success('添加成功！',url('/admin/node/index'));
            } else {
                $this->error('添加失败！');
            }
        } else {
            $Node = $NodeDB->getAllNode()->toArray();
            $array = array();
            foreach($Node as $k => $r) {
                $r['id']         = $r['id'];
                $r['title']      = $r['title'];
                $r['name']       = $r['name'];
                $r['disabled']   = $r['level']==3 ? 'disabled' : '';
                $array[$r['id']] = $r;
            }
            $str  = "<option value='\$id' \$selected \$disabled >\$spacer \$title</option>";
            $Tree = new Tree();
            $Tree->init($array);
            $select_categorys = $Tree->get_tree(0, $str, $pid);

            return view('admin.node_add',['select_categorys' => $select_categorys,'tpltitle' => '添加']);
        }
    }

    public function edit(Request $request ,$id = 0,$pid = 0) {
        $NodeDB = new Node();
        if(isset($_POST['dosubmit'])) {
            $data = $request->all();
            //控制器验证
            $this->validate($request, $NodeDB->getRules($data['id']),$NodeDB->getMessages($data['id']));

            $info = $NodeDB::find($data['id']);
            if($info) {
                if($info->update($data)) {
                    $this->success('修改成功！',url('/admin/node/index'));
                } else {
                    $this->error('修改失败！');
                }
            } else {
                $this->error("_404");
            }
        } else {
            if(!$id || !$pid) $this->error('参数错误!');
            $allNode = $NodeDB->getAllNode()->toArray();
            $array = array();
            foreach($allNode as $k => $r) {
                $r['id']         = $r['id'];
                $r['title']      = $r['title'];
                $r['name']       = $r['name'];
                $r['disabled']   = $r['level']==3 ? 'disabled' : '';
                $array[$r['id']] = $r;
            }
            $str  = "<option value='\$id' \$selected \$disabled >\$spacer \$title</option>";
            $Tree = new Tree();
            $Tree->init($array);
            $select_categorys = $Tree->get_tree(0, $str, $pid);
            return view('admin.node_add',['info' => $NodeDB->getNode(['id' => $id]),'select_categorys' => $select_categorys,'tpltitle' => '编辑']);
        }
    }

    //删除菜单
    public function del(Request $request,$id)
    {
        if(!$id) $this->error('参数错误!');
        $NodeDB = new Node();

        $info = $NodeDB -> getNode(array('id'=>$id),['id']);

        if($NodeDB->childNode($info['id'])->toArray()){
            $this->error('存在子菜单，不可删除!');
        }

        if($NodeDB->delNode(['id' => $id])) {
            $this->success('删除成功！',url('/admin/node/index'));
        } else {
            $this->error('删除失败!');
        }
    }

    //菜单排序权重更新
    public function sort()
    {
        $NodeDB = new Node();
        $sorts = $_POST['sort'];
        if(!is_array($sorts)) $this->error('参数错误!');
        foreach ($sorts as $id => $sort) {
            $NodeDB->where(['id' =>$id])->update(['sort' => intval($sort)]);
        }
        $this->success('更新完成！',url('/admin/node/index'));
    }


}