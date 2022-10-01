<?php  

namespace App\Core;

/* https://www.php.net/manual/en/function.session-create-id.php */

class SessionHelper {
    // My session start function support timestamp management
    public static function startSession() {
        session_start();
        // Do not allow to use too old session ID
        if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180) {
            session_destroy();
            session_start();
        }

        if (!isset($_SESSION['authenticated'])) {
            $_SESSION['authenticated'] = false;
        }
    }

    // My session regenerate id function
    public static function regenerateSessionId() {
        // Call session_create_id() while session is active to 
        // make sure collision free.
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        // WARNING: Never use confidential strings for prefix!
        $newid = session_create_id('RIHAKA-');
        // Set deleted timestamp. Session data must not be deleted immediately for reasons.
        $_SESSION['deleted_time'] = time();
        // Finish session
        session_commit();

        // Set new custom session ID
        session_id($newid);
        // Start with custom session ID
        session_start();
    }
}
?>
