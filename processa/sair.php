<?php
session_cache_limiter('nocache');
session_start();
session_destroy();
header("Location: ../index.php");