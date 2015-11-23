<?php
$c = new Checkout();
$c->order_id = (int)security(Routes::$func);
$c->payment_type = security(Routes::$get[1]);
