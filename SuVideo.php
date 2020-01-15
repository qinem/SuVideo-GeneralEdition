<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="postpage" class="blog-post">
    <article class="single-post panel">
            <?php if ($this->fields->mp4): ?>
                <link class="dplayer-css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
                <!--<script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>-->
                <script src="https://cdn.jsdelivr.net/npm/hls.js/dist/hls.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>
                <div id="dplayer"></div>

            <?php //$geturl = $this->fields->iframe;$str1 = explode('aid=', $geturl);$str2 = explode('&cid=', $str1[1]);$av = $str2[0];?>
            <?php $duoji="";
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
				/*
                $list= '<div class="card d-block mb-3"> <div class="card-header"><span>剧集</span>'.$duoji.'</div>
<div class="card-body button-list">'.$list.'</div></div>';*/
				/*$qinem= '<li class="nav-item"><a class="nav-link" href data-toggle="tab" data-target="#"><?php _me("'.$duoji.'") ?></a></li>';*/
				//$qin= '<li class="nav-item active">'.$duoji.'</li>';
				$list= '<div class="card d-block mb-3"><div class="card-body button-list">'.$list.'</div></div>';
                $spurl=explode("$",$string_arr[$j])[1];
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
            <?php endif; ?>

			
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
                <div class="list-group list-group-lg list-group-sp"><?php echo $list; ?><br><?php $this->content(); ?></div>
                    </div> 
			  </div>
            </div>
	</article>
</div>
