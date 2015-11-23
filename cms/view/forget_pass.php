<?php
echo '	<!-- Login wrapper begins -->
		<div class="loginWrapper">
		
			<!-- Current user form -->
		    <form method="POST" action="'.$site['url'].'sifremi-unuttum" id="login">
		        <div class="loginPic">
		            <span>'. title() .'</span>
		        </div>
		        
		        <input type="text" name="user_email" placeholder="'.$lang['Email'].'" class="loginEmail" />
		        
		        <div class="logControl">
		            <div class="memory">
		            	<ul style="text-align: left; margin-left:10px; margin-top:-10px;">
		            		<li><a href="'.$site['url'].'giris">&raquo; '.$lang['Sign_in'].'</a></li>
		            		<li><a href="'.$site['url'].'kayit">&raquo; '.$lang['Sign_up'].'</a></li>
		            	</ul>
		            	<!--
		            	<input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label>
		            	-->
		            </div>
		            <input type="submit" name="submit" value="'.$lang['Forget_my_password'].'" class="buttonM bBlue" />
		            <div class="clear"></div>
		        </div>
		    </form>
		    
		</div>
		<!-- Login wrapper ends -->';