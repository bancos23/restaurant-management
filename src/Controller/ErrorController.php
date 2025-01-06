<?php

namespace App\Controller;

class ErrorController {
    public function index() {
        ?>
        <div class="container">
            <div class="error-page">
                <div class="error-content">
                    <h3>Oops! Page not found.</h3>
                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may return to dashboard</a> or try using the search form.
                    </p>
                </div>
            </div>
        </div>
    <?php
    }
}
