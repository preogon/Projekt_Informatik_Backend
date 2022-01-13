<?php
use base\API;

$API = new API();

$API->register("/demo", "Actions\\Demo");

$API->execute();