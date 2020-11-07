<?php

include 'includes/classloader.inc.php';

$userContr = new UserContr();
$userContr->logoutUser();
header('Location: index.php');
