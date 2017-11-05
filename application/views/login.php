<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="splash-container">
    	<div class="splash">

			<h1 class="header">FIND<span>R</span></h1>
			<h2 class="header">Prototyp<span>e</span></h2>
	
			<form id="login" action="/users/login/process" method="post">

				<?php echo prompt(); ?>

				<label for="email">Email</label>
				<input type="email" name="email" id="email" placeholder="email@findr.com" />

				<label for="password">Password</label>
				<input type="password" name="password" id="password" placeholder="password" />

				<input type="submit" value="Log In" />
			</form>
		</div>
	</div>