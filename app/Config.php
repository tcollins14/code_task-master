<?php

namespace app;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'code_task-master';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'mvcusername';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'mvcpassword';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    const SECRET_KEY = 'I1WP4LFKs0LCkw3aZ3i9ZN1sa20Qbzu9';

    const MAILGUN_API_KEY = 'key-51ce81897a2b84adcf7ad2047e41050d';

    const MAILGUN_DOMAIN = 'mg.tomcollins.io';
}
