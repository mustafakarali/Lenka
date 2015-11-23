<?php
echo '	<!-- Login wrapper begins -->
		<div class="loginWrapper">
			<!-- Current user form -->
		    <form method="POST" action="'.Routes::$current.'" id="login">
		        <div class="loginPic">
		            <span>'. Seo::title() .'</span>
		        </div>
		        
		        <input type="text" name="user_email" placeholder="'. __('Email') .'" class="loginEmail" />
		        <input type="password" name="user_pass" placeholder="'. __('Password').'" class="loginPassword" />
		        
		        <div class="logControl">
		            <div class="memory">
		            	<ul style="text-align: left; margin-left:10px; margin-top:-10px;">
		            		<!--
		            		<li><a href="'.Routes::$base.'kayit">&raquo; '. __('Sign up').'</a></li>
		            		<li><a href="'.Routes::$base.'sifremi-unuttum">&raquo; '. __('Forget my password').'</a></li>
		            		-->
		            	</ul>
		            	<!--
		            	<input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label>
		            	-->
		            </div>
		            <input type="submit" name="submit" value="'. __('Sign in') .'" class="buttonM bBlue" />
		            <div class="clear"></div>
		        </div>
		    </form>
		
		</div>
		<!-- Login wrapper ends -->';