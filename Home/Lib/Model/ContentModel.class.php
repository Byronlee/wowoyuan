<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ContentModel.class.php $

    @Author zhang $

    @Date 2011-10-08 10:38:20 $
*************************************************************/
//  ��ݱ�Content������������
class ContentModel extends Model{
//����
    public function doreply($content,$sid,$isret,$type='') {
        $type=$type?$type:L('fromweb');
        if ($this->my['userlock']==2) {
            $ret=array('ret'=>L('user_jingyan_reply'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        $cm=D('Comments');
        $uModel=D('Users');
        $content=daddslashes(trim($content));
        $content=$this->replace($content);
        if ($this->typenums($content)>140) {
            $ret=array('ret'=>L('talklong'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        if ($sid && $content) {
            $data = $this->where("content_id='$sid'")->find();
            if($data && $this->my['user_id']) {
                //����
                $blackuids=$this->getblacker();
                if (in_array($data['user_id'],$blackuids)) {
                    $ret=array('ret'=>L('blackuser'),'insertid'=>0);
                    return json_encode($ret);
                    exit;
                }
                //attopicurl replace
                $attopicurl=$this->attopicurl($content,0);
                $content=$attopicurl[0];
                $dt=$attopicurl[1];
                //insert
                $insert['user_id']=$this->my['user_id'];
                $insert['content_body']=$content;
                $insert['posttime']=time();
                $insert['replyid']=$sid;
                $insert['type']=$type;
                $insertid=$this->add($insert);

                $plugin= new pluginManager();//��ʼ���������
                $plugin->do_action('reply');//hook

                $this->setInc('replytimes',"content_id='$sid'");

              

                //add content_mention
                $uids=$dt['uids'];
                $uids[]=$data['user_id'];
                $uids=array_unique($uids);
                foreach ($uids as $val) {
                    if ($val!=$this->my['user_id']) {
                        $com['user_id']=$val;
                        $com['comment_uid']=$this->my['user_id'];
                        $com['content_id']=$sid;
                        $com['comment_body']=$content;
                        $com['dateline']=time();
                        $cm->add($com);
                        $uModel->setInc('comments',"user_id='$val'");
                    }
                }

                $ret=array('ret'=>'success','insertid'=>$insertid);

                return json_encode($ret);
            } else {
                $ret=array('ret'=>L('data_error'),'insertid'=>0);
                return json_encode($ret);
            }
        } else {
            $ret=array('ret'=>L('talk_null'),'insertid'=>0);
            return json_encode($ret);
        }
    }
    
    function loadoneli($data) {
        $user_id=$data['user_id'];
        $user_name=$data['username'];
        $content_body = $data['content_body'];
        $content_id   = $data['content_id'];
        $posttime     = '2009-1-0';
        $r = '<div class="everymess"><img src="/Public/images/head/2.png" /><div class="neirong"><div class="xie"><a class="shanname" href="">'.$user_name.'</a>:'.$content_body.$posttime.'<a class="huiyinging" href="">Replay</a></div>';
        $r.= '<div class="replay"><a href="">'.$user_name.'</a>:'.$data['replay_body'].'</div>';
        $r.= '</div></div>';
        return $r;

    }
    function loadonereply($data,$wide=0) {
        if ($this->my && $this->my['user_id']!=$data['user_id']) {
            $rep="<a href='javascript:void(0)' class='fright' style='margin-left:5px' onclick=\"replyajaxin('{$data[replyid]}','{$data[nickname]}')\">".L('reply')."</a>";
        }
        if ($wide==0) {
            if ($this->my && ($this->my['user_id']==$data['user_id'] || $this->my['isadmin']>0)) {
                $rep.='<a href="javascript:void(0)" class="fright" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\''.L('del_talk_confirm').'\',this.parentNode.parentNode.parentNode.parentNode)">'.L('delete').'</a>';
            }
            return stripslashes('<li class="lire">
                <div class="images"><a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'"><img src="'.sethead($data['user_head']).'" width="30px" height="30px" alt="'.$data['nickname'].'"></a></div>
                <div class="info">
                    <p><a class="username '.setvip($data['user_auth']).'" '.viptitle($data['user_auth']).' href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'">'.$data['nickname'].'</a>
                    <span class="setgray">'.timeop($data['posttime']).'&nbsp;&nbsp;'.L('tfrom').$data['type'].'&nbsp;'.$rep.'</span></p>
                    <p>'.$this->ubb($data['content_body']).'</p>
                </div>
            </li>');
        } else {
            if ($this->my && ($this->my['user_id']==$data['user_id'] || $this->my['isadmin']>0)) {
                $rep.='<a href="javascript:void(0)" class="fright" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\''.L('del_talk_confirm').'\',this.parentNode.parentNode)">'.L('delete').'</a>';
            }
            return stripslashes('<li class="unlight">
            <a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'" class="avatar"><img src="'.sethead($data['user_head']).'" alt="'.$data['nickname'].'" /></a>
            <div class="content"><a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'" class="author">'.$data['nickname'].'</a><h5>'.L('reply').':</h5>'.$this->ubb($data['content_body']).'</div><span class="stamp" style="float:left">'.timeop($data['posttime']).'&nbsp;&nbsp;'.L('tfrom').$data['type'].'</span><span class="stamp op" style="float:right;white-space:nowrap">'.$rep.'</span><div class="clearline"></div></li>');
        }
    }

    function wapli($data,$mid,$from,$showspeaker,$showtool=1,$favor=0) {
        $delbtn=$speaker='';
        if ($data['user_id']==$mid) {
            $delbtn="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/delmsg/cid/$data[content_id]/from/".base64_encode($from)."'>".L('delete')."</a>";
        }
        if ($showspeaker==1) {
            $speaker="<a href='".SITE_URL."/Wap/space/user_name/".rawurlencode($data['user_name'])."' class='".setvip($data['user_auth'])."' ".viptitle($data['user_auth']).">$data[nickname]</a> ";
        }
        
    }
    public function sendmsg($content,$morecontent,$from='',$condition='') {
        $from=$from?$from:L('fromweb');
        $uModel=D('Users');
        if ($condition) {
            foreach ($condition as $key=>$val) {
                $where[]=$key.'="'.$val.'"';
            }
            $cond=implode(' AND ',$where);
            if ($cond) {
                $user=$uModel->where($cond)->find();
                if (!$user) {
                    $ret=array('ret'=>L('no_exist_user'),'insertid'=>0);
                    return json_encode($ret);
                    exit;
                }
            } else {
                $ret=array('ret'=>L('no_exist_user'),'insertid'=>0);
                return json_encode($ret);
                exit;
            }
        } else {
            $user=$this->my;
        }
        $content=daddslashes(trim($content));
        if ($this->typenums($content)>140) {
            $ret=array('ret'=>L('talklong'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        $morecontent=daddslashes(trim($morecontent));
        if ($user['userlock']==2) {
            $ret=array('ret'=>L('user_jingyan'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        $content=$this->replace($content); //�������
        if (!empty($content) && $user['user_id']) {
            $type=$morecontent?'photo':'';
            if ($user['lastcontent']==$content) {
                $ret=array('ret'=>L('same_talk'),'insertid'=>0);
                return json_encode($ret);
            }
            //attopicurl replace
            $attopicurl=$this->attopicurl($content);
            $content=$attopicurl[0];
            $atreplace=$attopicurl[1];
            $topicid=$attopicurl[2];
            //share
            preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9_\-]+\.)+[A-Za-z0-9\:]{2,10}(?:\/[\w\d\/=\?%\-\&_\~`@\[\]\:\+\#\.]*(?:[^<>\'\"\n\r\t\s])*)?~',$content,$match1);
            if(!empty($match1[0])) {
                $stringlink = implode(glue,$match1[0]);
                $stringlink = str_replace('[/U]','',$stringlink);
                if($stringlink != $is_post_url) {
                    $vidoLink = parse_url($stringlink);
                    $vido_host = get_host($vidoLink['host']);
                    $ReturnMusic = preg_match("/\.(mp3|wma)$/i", $stringlink);
                    $ReturnFlash = preg_match("/\.(flv|swf)$/i", $stringlink);
                    $ReturnHost = preg_match("/(youku\.com|ku6\.com|sohu\.com|mofile\.com|sina\.com\.cn|tudou\.com|youtube\.com)$/i", $vido_host);
                    if($ReturnHost == 1 && !$ReturnFlash && !$ReturnMusic) {
                        if('youku.com' == $vido_host){
                            $youku = file_get_contents($stringlink);
                            preg_match_all("/<li class=\"download\"(.*)<\/li>/",$youku,$match2);
                            preg_match_all("/id\_(\w+)[=.]/",$stringlink,$matches);//http://v.youku.com/v_show/id_XMjYwNTExOTU2.html
                            if(empty($matches[1][0])){//http://v.youku.com/v_playlist/f6020209o1p0.html
                                preg_match_all("/iku\:\/\/\|video\|http\:\/\/v.youku.com\/v_show\/id\_(.*?)\.html/",$match2[1][0],$matches);
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            preg_match("/\|(http\:\/\/g\d\.ykimg\.com\/[^\|]+)\|/",$match2[1][0],$imageurl);
                            if (!$imageurl[1]) {
                                preg_match_all('/<a title="ת��������΢��"(.*?)href="(.*?)pic=(.*?)"(.*?)>/',$youku,$match3);
                                $returnImage = $match3[3][0];
                            } else {
                                $returnImage = $imageurl[1];
                            }
                        } elseif('tudou.com' == $vido_host) {
                            $tudou = file_get_contents($stringlink);
                            $tudou = iconv('gbk','utf-8//IGNORE',$tudou);
                            preg_match_all("/view\/([\w])/",$stringlink,$matches);//http://www.tudou.com/programs/view/H4NhH5nvSgs/
                            preg_match_all("/thumbnail = pic = '(.*?)'/",$tudou,$imageurl); //,thumbnail = pic = 'http://i3.tdimg.com/094/109/402/m25.jpg'
                            if(empty($matches[1][0])){
                                preg_match_all('/icode\:"(.*?)"/',$tudou,$matches);//http://www.tudou.com/playlist/p/l12038429.html
                                preg_match_all('/pic\:"(.*?)"/',$tudou,$imageurl);
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $returnImage = $imageurl[1][0];
                        } elseif('ku6.com' == $vido_host) {
                            $ku6 = file_get_contents($stringlink);
                            $ku6 = iconv('gbk','UTF-8',$ku6);
                            preg_match_all("/$ns.href = 'http\:\/\/v.ku6.com\/special\/show_([\w\-]+)\/([\w\-]+).html'/", $ku6,$matches);//all
                            if(!empty($matches[2][0])) {
                                $returnlink = $matches[2][0];
                            }
                            preg_match_all("/<span class=\"s_pic\">(.*)<\/span>/",$ku6,$imageurl);
                            $returnImage = $imageurl[1][0];
                        } elseif('mofile.com' == $vido_host){
                            preg_match_all("/\/([\w\-]+)\.shtml/",$stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $mofile = file_get_contents($stringlink);
                            preg_match_all("/thumbpath=\"(.*?)\";/i",$mofile,$imageurl);
                            $returnImage = $imageurl[1][0];
                        } elseif('sina.com.cn' == $vido_host) {
                            preg_match_all("/\/(\d+)\-(\d+)\.html/i",$stringlink,$matches);//http://video.sina.com.cn/v/b/51187154-1854900491.html
                            $sina = file_get_contents($stringlink);
                            preg_match_all("/pic: \'(.*?)\',/i",$sina,$imageurl);
                            $returnImage = $imageurl[1][0];
                            if(empty($matches[1][0])){
                                if ($vidoLink['host']=='video.sina.com.cn') {//http://video.sina.com.cn/p/news/c/v/2011-05-02/131861328229.html
                                    preg_match_all("/swfOutsideUrl:\'http:\/\/you.video.sina.com.cn\/api\/sinawebApi\/outplayrefer.php\/vid=(.*?)\/s\.swf\',/i", $sina, $matches);
                                    preg_match_all("/pic: \'(.*?)\',/i",$sina,$imageurl);
                                    $returnImage = $imageurl[1][0];
                                } else if ($vidoLink['host']=='tv.video.sina.com.cn') {//http://tv.video.sina.com.cn/play/95177.html
                                    preg_match_all("/\/(\d+)\.html/i", $stringlink, $matches);
                                    preg_match_all("/onerror=\"this.src=\'(.*?)\'\"/i",$sina,$imageurl);
                                    $returnImage = $imageurl[1][0];
                                }
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                        } elseif('sohu.com' == $vido_host) {
                            preg_match_all("/\/(\d+)\/"."*$/",$stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                        } elseif('youtube.com' == $vido_host) {
                            //http://www.youtube.com/watch?v=oyi3_IDM2Kk
                            preg_match_all("/watch\?v=([\w\-]+)/",$stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $youtube = file_get_contents($stringlink);
                            preg_match_all('/<meta property="og:image" content="(.*)">/',$youtube,$imageurl);
                            $returnImage = $imageurl[1][0];
                        }
                        if ($returnlink) {
                            $returnImage=$returnImage?$returnImage:__PUBLIC__.'/images/video.gif';
                            $share="[V h={$vido_host} p={$returnImage}]{$returnlink}[/V]";
                            $type='video';
                        }
                    } else if($ReturnMusic == 1) {
                        $share="[M]{$stringlink}[/M]";
                        $type='music';
                    } else if($ReturnFlash == 1) {
                        $share="[M]{$stringlink}[/M]";
                        $type='video';
                    }
                }
            }
            $morecontent.=$share;
            $insert['user_id']=$user['user_id'];
            $insert['content_body']=$content;
            $insert['media_body']=$morecontent;
            $insert['type']=$from;
            $insert['filetype']=$type;
            $insert['posttime']=time();
            $insertid=$this->add($insert);

            //hook
            $plugin= new pluginManager();//��ʼ���������
            $plugin->do_action('sendtalk');

            $uModel->where("user_id='".$user['user_id']."'")->setField(array('msg_num','lastcontent','lastconttime'),array(array('exp','msg_num+1'),$content,time()));
            //add content_topic
            if (is_array($topicid)) {
                $ct=D('Content_topic');
                foreach($topicid as $val) {
                    $ctdata['topic_id']=$val;
                    $ctdata['content_id']=$insertid;
                    $ct->add($ctdata);
                }
            }
            //add content_mention
            $uids=$atreplace['uids'];
            if ($uids) {
                //����
                $blackuids=$this->getblacker();
                $cm=D('Content_mention');
                foreach($uids as $val) {
                    if (!in_array($val,$blackuids)) {
                        $cmdata['cid']=$insertid;
                        $cmdata['user_id']=$val;
                        $cmdata['dateline']=time();
                        $cm->add($cmdata);
                    }
                }
            }
            if ($type=='photo') {
                $plugin->do_action('photo');
            } else if ($type=='video' || $type=='music') {
                $plugin->do_action('share');
            }
            $ret=array('ret'=>'success','insertid'=>$insertid);
            return json_encode($ret);
        } else {
            $ret=array('ret'=>L('send_talk_error'),'insertid'=>0);
            return json_encode($ret);
        }
    }
}
?>