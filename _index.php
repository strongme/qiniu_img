
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">七牛配置</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" action="options.php" method="POST">
						<?php settings_fields('qiniuimg_options'); ?>
						<div class="form-group">
							<label for="accesskey" class="col-sm-2 control-label">AccessKey</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="AccessKey" name="qiniuimg_accesskey" id="qiniuimg_accesskey" value="<?php echo esc_attr(get_option('qiniuimg_accesskey')); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="secretkey" class="col-sm-2 control-label">SecretKey</label>
							<div class="col-sm-10">
								<input type="password" class="form-control"  placeholder="SecretKey" name="qiniuimg_secretkey" id="qiniuimg_secreykey" value="<?php echo esc_attr(get_option('qiniuimg_secretkey')); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="bucket" class="col-sm-2 control-label">Bucket</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="Bucket" name="qiniuimg_bucket" id="qiniuimg_bucket" value="<?php echo esc_attr(get_option('qiniuimg_bucket')); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="bucket" class="col-sm-2 control-label">Bucket Domain</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" placeholder="Domain" name="qiniuimg_domain" id="qiniuimg_domain" value="<?php echo esc_attr(get_option('qiniuimg_domain')); ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-info">保存</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">作者</h3>
				</div>
				<div class="panel-body text-center">
					<a href="http://www.weibo.com/strongwalter" target="_blank">@奔跑的阿水哥</a>-|-<a href="http://strongme.cn" target="_blank">译邻</a>-|-<a href="http://do.strongme.cn" target="_blank">番羽土啬</a><br>
					<a href="mailto:strongwalter2014@gmail.com">strongwalter2014@gmail.com</a>
				</div>
			</div>
		</div>
		<div class="col-md-6" >
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">说明</h3>
				</div>
				<div class="panel-body">
					<blockquote style="font-size:10px;">
						<strong>要求</strong>：<br>因为作者CSS不太会，因此就借助了Bootstrap3来实现图片排版，如果你使用的主题不是Bootstrap3制作的，那不好意思，不能用哦，不然排版都是乱的。<hr>
						<strong>原理</strong>：<br>因为七牛存储支持前缀，因此就可以使用前缀来起到分类作用，按照任何你需要的分类方法都可以。<hr>
						<strong>配置要求</strong>：<br>按照左侧提示输入七牛相关配置信息。<hr>
						<strong>使用方法</strong>：在任何你想加载七牛存储的图片的地方使用此短代码：<br><br>
						
						<ul>
							<li>[qiniu_img prefix="xxx" size="10" groupsize="6"]</li>
							<li>prefix:是前缀</li>
							<li>size:是要加载的图片数量，不写默认加载全部</li>
							<li>groupsize:因为使用了Bootstrap栅格排版，表示一行几张图片可选项为能把12整出的整数</li>
						</ul>
					</blockquote>
				</div>
			</div>
			
			
		</div>
	</div>
