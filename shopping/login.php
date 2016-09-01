<?php 
include('fns_book_sc.php');
session_start();

do_html_header('Login');

?>
<div class="login">
	<h1>Administration</h1>
	<form action="admin.php" method="post">
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" size="16"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="passwd" size="16"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="Login" value="Login"></td>
			</tr>
		</table>
	</form>
</div>
<?php 
	do_html_footer();
?>