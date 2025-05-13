<?php

define('BASE_DIR', realpath(__DIR__ . '/..'));

define('BASE_URL', 'http://localhost:8000');
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ACTION', 'index');

// Roles
define('ROLE_ADMIN', 'admin');
define('ROLE_ORGANIZER', 'organizer');
define('ROLE_EMPLOYEE', 'employee');

// Status
define('STATUS_PLANNED', 'planned');
define('STATUS_ONGOING', 'ongoing');
define('STATUS_COMPLETED', 'completed');
define('STATUS_CANCELLED', 'cancelled');

define('RESERVATION_CONFIRMED', 'confirmed');
define('RESERVATION_PENDING', 'pending');
define('RESERVATION_CANCELLED', 'cancelled');
define('RESERVATION_WAITING', 'waiting_list');