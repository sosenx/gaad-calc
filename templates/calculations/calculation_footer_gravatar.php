<br>
<br>
<br>
<table class="calculation-footer-gravatar">
	<?php
	$description = str_replace("\n", "<br>", $user->description );
	$first_name = str_replace("\n", "<br>", $user->first_name );
	$last_name = str_replace("\n", "<br>", $user->last_name );

    $email = $user->user_email;
	?>

	<tbody>
		
		<tr>		
			<td class="gravatar"  valign="top"><?php echo '<img src="data:' . $size['mime'] . ';base64,' . "\n" . $avatar_base64 . '" ' . $size[3] . ' />', "\n"; ?></td>
			
			<td class="text-data" valign="top">
			</td>

			<td class="text-data" valign="top">
				<h3 class="name_first_last"><?php echo $first_name . ' ' .$last_name; ?></h3>
				<p class="description"><?php echo $description; ?></p>
				<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
				<hr>

				<p>Mazowieckie Centrum Poligrafii Wojciech Hunkiewicz<br>05-270 Marki, ul.Ciurlionisa 4</p>
			</td>
		</tr>


	</tbody>

</table>

