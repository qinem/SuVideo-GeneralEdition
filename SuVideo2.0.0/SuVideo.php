<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<style type="text/css">
	.photo{
		float:left;
		width:20%;
		table-layout: fixed;
		word-wrap:break-word;
	}
	.intro{
		float:right;
		width:80%;
	}
	.qin{
		float:none;
	}
	.container {width: 100%;}
	.photo {float: left; width: 40%;}
	.content {float: right; width: 60%;}
</style>
<div id="postpage" class="blog-post">
    <article class="single-post panel">
        <div id="dplayer"></div>
            <?php 
			$duoji="";
            if($this->fields->duoji && strpos($this->fields->duoji,'$') !== false){
                $hang = explode("\r\n", $this->fields->duoji);
                $shu=count($hang);
                for($i=0;$i<$shu;$i++){
                    $cid=explode("$",$hang[$i])[1];
                    $this->widget('Widget_Archive@duoji'.$cid, 'pageSize=1&type=post', 'cid='.$cid)->to($ji);
                    if($ji->cid==$this->cid){
                        $duoji=$duoji."<span class=\"btn btn-outline-danger btn-sm ml-1 border-0 disabled\">".explode("$",$hang[$i])[0]."</span>";
                    }else{
                        $duoji=$duoji."<a href=\"".$ji->permalink."\" class=\"btn btn-outline-danger btn-sm ml-1 border-0\">".explode("$",$hang[$i])[0]."</a>";
                    }
                }
            }
			if($this->fields->m3u8){
				$spurl=$this->fields->m3u8;
				$qin_yuan=file_get_contents($spurl); 
				$qin_f1=explode("m3u8</span></h3>",$qin_yuan);
				$qin_f2=explode("</ul>",$qin_f1[1]);
				$qin_f3=explode("第",$qin_f2[0]);
				$qin_p1=count($qin_f3);
				for($a=1;$a<$qin_p1;$a++)
				{
					$qin_ge=explode("m3u8</li>",$qin_f3[$a]);
					$qin_ji=$qin_ji."第".$qin_ge[0]."m3u8\r\n";
				}
				$x=0;
				if(strpos($qin_ji,'$') !== false)
				{
					$j=0;
					if(isset($_GET['action']))
					{
						if($_GET['action'] == 'get' && 'GET' == $_SERVER['REQUEST_METHOD'] )
						{
							$j=$_GET['p']-1;
						}
					}
					$txt=$qin_ji;
					$string_arr = explode("\r\n", $txt);
					$long=count($string_arr);
					$list="";
					for($i=0;$i<$long;$i++)
					{
						if($j==$i)
						{
							$c="class=\"btn btn-primary c\"";}else{$c="class=\"btn btn-outline-primary\"";
						}
						$p=$i+1;
						$list=$list."<a href=\"".$this->permalink."?action=get&p=".$p."\"".$c.">".explode("$",$string_arr[$i])[0]."</a>";
					}
					$list= '<div class="card d-block mb-3"><div class="card-body button-list">'.$list.'</div></div>';
					$spurl=explode("$",$string_arr[$j])[1];
				}
				$qin_j1=explode("剧情介绍：</strong>",$qin_f1[0]);
				$qin_j2=explode("</div>",$qin_j1[1]);
				$qin_j3=explode(">",$qin_j2[1]);
				$qin_js=$qin_j2[1];
			}else{
				$spurl=$this->fields->mp4;
				$x=0;
				if(strpos($this->fields->mp4,'$') !== false)
				{
					$j=0;
					if(isset($_GET['action']))
					{
						if($_GET['action'] == 'get' && 'GET' == $_SERVER['REQUEST_METHOD'] )
						{
							$j=$_GET['p']-1;
						}
					}
					$txt=$this->fields->mp4;
					$string_arr = explode("\r\n", $txt);
					$long=count($string_arr);
					$list="";
					for($i=0;$i<$long;$i++)
					{
						if($j==$i)
						{
							$c="class=\"btn btn-primary c\"";}else{$c="class=\"btn btn-outline-primary\"";
						}
						$p=$i+1;
						$list=$list."<a href=\"".$this->permalink."?action=get&p=".$p."\"".$c.">".explode("$",$string_arr[$i])[0]."</a>";
					}
					$list= '<div class="card d-block mb-3"><div class="card-body button-list">'.$list.'</div></div>';
					$spurl=explode("$",$string_arr[$j])[1];
				}
			}
			
			
            ?>
                <script>
                    const dp = new DPlayer({
                        container: document.getElementById('dplayer'),
                        screenshot: false,lang: 'zh-cn',
                        //autoplay: true,
                        video: {
                            url: '<?php echo $spurl; ?>',type: 'auto',
                            //pic: '',
                            //thumbnails: '',
                        },
                    });
                </script>

			
	</article>

	<article class="single-post panel">
	<div class="wrapper-md">
               <div class="tab-container post_tab">
                <ul class="nav no-padder b-b">
                	<li class="nav-item active"><a class="nav-link" href data-toggle="tab" data-target="#my-info"><?php
                            _me("剧集")
                            ?></a></li><?php echo $duoji; ?>
							
          
                </ul>
				<div class="tab-pane fade in" id="#my-info">
                <div class="list-group list-group-lg list-group-sp"><?php echo $list; ?><br>
				<?php 
				if($this->fields->mp4){
					echo Content::postContent($this,$this->user->hasLogin());
				}else{
					echo $qin_js;
				}
				?></div>
                    </div> 
			  </div>
            </div>
	</article>
</div>
