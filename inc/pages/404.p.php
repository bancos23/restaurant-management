<?php
/**
 * @file 404.p.php
 * @brief 404 Error Page
 * @details
 *
 * This file is responsible for displaying the 404 error page when a user
 * tries to access a page that does not exist. It provides a message to the
 * user indicating that the page was not found and offers a link to return
 * to the dashboard or use the search form.
 *
 * @author Mirth Kevin
 * @date 2024-11-30
 */
 ?>
<div class="container">
	<div class="error-page">
		<div class="error-content">
			<h3>Oops! Page not found.</h3>
			<p>
            	We could not find the page you were looking for.
            	Meanwhile, you may <a href="<?php echo BASE_URL ?>">return to dashboard</a> or try using the search form.
          	</p>
		</div>
	</div>
</div>