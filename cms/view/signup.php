<?php
echo '	<!-- Login wrapper begins -->
		<div class="loginWrapper">
		
			<!-- Current user form -->
		    <form method="POST" action="'.$url->page.'" id="login">
		        <div class="loginPic">
		            <span>'. title() .'</span>
		        </div>
		        
		        <input type="text" name="user_email" placeholder="'.$lang['Email'].'" class="loginEmail" />
		        <input type="password" name="user_pass1" placeholder="'.$lang['Password'].'" class="loginPassword" />
		        <input type="password" name="user_pass2" placeholder="'.$lang['Password'].'" class="loginPassword" />
		        
		        <div class="logControl">
		            <div class="memory">
		            	<ul style="text-align: left; margin-left:10px; margin-top:-10px;">
		            		<li><a href="'.$site['url'].'giris">&raquo; '.$lang['Sign_in'].'</a></li>
		            		<li><a href="'.$site['url'].'sifremi-unuttum">&raquo; '.$lang['Forget_my_password'].'</a></li>
		            	</ul>
		            	<!--
		            	<input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label>
		            	-->
		            </div>
		            <input type="submit" name="yonetim_kayit_submit" value="'.$lang['Sign_up'].'" class="buttonM bBlue" />
		            <div class="clear"></div>
		        </div>
		    </form>
		</div>
		<!-- Login wrapper ends -->';