<?php
if ( !defined( 'DEBUG' ) )
	die;


// TODO: make ajax
//$pagetmp = Flash::get( 'page' );
//$parttmp = Flash::get( 'page_parts' );
//
//if ( $pagetmp != null && !empty( $pagetmp ) && $parttmp != null && !empty( $parttmp ) && $tagstmp != null && !empty( $tagstmp ) )
//{
//	$page = $pagetmp;
//	$parts = $parttmp;
//}
?>

<h1><?php echo __( ucfirst( $action ) . ' Page' ); ?></h1>

<?php if ( $action == 'edit' ): ?>
	<p class="view-button" id="page_edit_view"><a href="<?php echo(URL_PUBLIC . (USE_MOD_REWRITE === false ? '?/' : '') . ($uri = $page->getUri()) . (strstr( $uri, '.' ) === false && $uri != '' ? URL_SUFFIX : '')); ?>" target="_blank" title="<?php echo __( 'In a new window' ); ?>"><?php echo __( 'View this page' ); ?></a></p>
<?php endif; ?>

<form id="page_edit_form" action="<?php
if ( $action == 'add' )
	echo get_url( 'page/add/' . $page->parent_id . '/' . $page->layout_id ); else
	echo get_url( 'page/edit/' . $page->id );
?>" method="post" class="dform page-edit">
	<input id="page_parent_id" name="page[parent_id]" type="hidden" value="<?php echo $page->parent_id; ?>" />

	<div class="dform-area">
		<!-- dform-area -->

		<div id="page_edit_options">
			<!-- page_edit_options -->
			<div id="page_edit_title"><input id="page_edit_title_input" type="text" name="page[title]" value="<?php echo $page->title; ?>" maxlength="255" size="255" class="input-text" /></div>

			<div id="page_more">
				<table class="dform-table">
					<?php if ( $page->parent_id != 0 ) : ?>
						<tr>
							<td class="dtable-label"><label for="page_slug"><?php echo __( 'Slug' ); ?></label></td>
							<td class="dtable-field"><input class="input-text" id="page_slug" maxlength="100" name="page[slug]" size="100" type="text" value="<?php echo $page->slug; ?>" /></td>
						</tr>
					<?php endif; ?>

					<tr>
						<td class="dtable-label"><label for="page_breadcrumb"><?php echo __( 'Breadcrumb' ); ?></label></td>
						<td class="dtable-field"><input class="input-text" id="page_breadcrumb" maxlength="160" name="page[breadcrumb]" size="160" type="text" value="<?php echo htmlentities( $page->breadcrumb, ENT_COMPAT, 'UTF-8' ); ?>" /></td>
					</tr>
					<tr>
						<td class="dtable-label dtable-optional"><label for="page_keywords"><?php echo __( 'Keywords' ); ?></label></td>
						<td class="dtable-field"><input class="input-text" id="page_keywords" maxlength="255" name="page[keywords]" size="255" type="text" value="<?php echo $page->keywords; ?>" /></td>
					</tr>
					<tr>
						<td class="dtable-label dtable-optional"><label for="page_description"><?php echo __( 'Description' ); ?></label></td>
						<td class="dtable-field"><input class="input-text" id="page_description" name="page[description]" size="255" value="<?php echo $page->description; ?>" /></td>
					</tr>

				</table>
				<?php if ( AuthUser::hasPermission( 'administrator' ) || AuthUser::hasPermission( 'developer' ) ): ?>
					<p id="page_edit_login" title="<?php echo __( 'When enabled, users have to login before they can view the page.' ); ?>">
						<label for="page_needs_login"><?php echo __( 'Use Login' ); ?></label>
						<select class="input-select" id="page_needs_login" name="page[needs_login]">
							<option value="<?php echo Page::LOGIN_INHERIT; ?>"<?php echo $page->needs_login == Page::LOGIN_INHERIT ? ' selected="selected"' : ''; ?>>&ndash; <?php echo __( 'inherit' ); ?> &ndash;</option>
							<option value="<?php echo Page::LOGIN_NOT_REQUIRED; ?>"<?php echo $page->needs_login == Page::LOGIN_NOT_REQUIRED ? ' selected="selected"' : ''; ?>><?php echo __( 'not required' ); ?></option>
							<option value="<?php echo Page::LOGIN_REQUIRED; ?>"<?php echo $page->needs_login == Page::LOGIN_REQUIRED ? ' selected="selected"' : ''; ?>><?php echo __( 'required' ); ?></option>          
						</select>
					</p>

					<p id="page_edit_protected" title="<?php echo __( 'When enabled, only users who are an administor can edit the page.' ); ?>">
						<label for="page_needs_login"><?php echo __( 'Protected' ); ?></label>
						<select class="input-select" id="page_is_protected" name="page[is_protected]">
							<option value="0"><?php echo __( 'No' ); ?></option>
							<option value="1" <?php if ( $page->is_protected )
					echo('selected'); ?> ><?php echo __( 'Yes' ); ?></option>
						</select>
					</p>
					<p id="page_edit_layout">
						<label for="page_layout_id"><?php echo __( 'Layout' ); ?></label>
						<select class="input-select" id="page_layout_id" name="page[layout_id]">
							<option value="0">&ndash; <?php echo __( 'inherit' ); ?> &ndash;</option>
							<?php foreach ( $layouts as $layout ): ?>
								<option value="<?php echo $layout->id; ?>"<?php echo $layout->id == $page->layout_id ? ' selected="selected"' : ''; ?>><?php echo $layout->name; ?></option>
							<?php endforeach; ?>
						</select>
					</p>

					<p id="page_edit_type">
						<label for="page_behavior_id"><?php echo __( 'Page Type' ); ?></label>
						<select class="input-select" id="page_behavior_id" name="page[behavior_id]">
							<option value=""<?php if ( $page->behavior_id == '' )
							echo ' selected="selected"'; ?>>&ndash; <?php echo __( 'none' ); ?> &ndash;</option>
									<?php foreach ( $behaviors as $behavior ): ?>
								<option value="<?php echo $behavior; ?>"<?php if ( $page->behavior_id == $behavior )
									echo ' selected="selected"'; ?>><?php echo Inflector::humanize( $behavior ); ?></option>
									<?php endforeach; ?>
						</select>
					</p>
				<?php endif; ?>
				<?php Observer::notify( 'view_page_edit_options', $page ); ?>

			</div>
			<div id="page_more_button"><a href="javascript:void(0);"><?php echo __( 'More options' ); ?></a></div>

			<!-- /page_edit_options -->
		</div>



		<div id="page_edit_parts">
			<!-- page_edit_parts -->




			<!-- page_edit_items -->
			<?php
			$index = 1;

			foreach ( $parts as $part )
			{
				echo $part->edit( array('index' => $index, 'part' => $part) );
				$index++;
			}
			?>
			<!-- /page_edit_items -->


			<!-- /page_edit_parts -->
		</div>



		<div id="page_edit_settings">
			<!-- page_edit_settings -->



			<?php if ( !isset( $page->id ) || $page->id != 1 ): ?>
				<p id="page_edit_status">
					<label for="page_status_id"><?php echo __( 'Status' ); ?></label>
					<select class="input-select" id="page_status_id" name="page[status_id]">
						<option value="<?php echo Page::STATUS_DRAFT; ?>"<?php echo $page->status_id == Page::STATUS_DRAFT ? ' selected="selected"' : ''; ?>><?php echo __( 'Draft' ); ?></option>
						<option value="<?php echo Page::STATUS_REVIEWED; ?>"<?php echo $page->status_id == Page::STATUS_REVIEWED ? ' selected="selected"' : ''; ?>><?php echo __( 'Reviewed' ); ?></option>
						<option value="<?php echo Page::STATUS_PUBLISHED; ?>"<?php echo $page->status_id == Page::STATUS_PUBLISHED ? ' selected="selected"' : ''; ?>><?php echo __( 'Published' ); ?></option>
						<option value="<?php echo Page::STATUS_HIDDEN; ?>"<?php echo $page->status_id == Page::STATUS_HIDDEN ? ' selected="selected"' : ''; ?>><?php echo __( 'Hidden' ); ?></option>
					</select>
				</p>
			<?php endif; ?>

			<?php if ( isset( $page->published_on ) && isset( $page->id ) and $page->id != 1 ): ?>
				<p id="page_edit_published">
					<label for="page_published_on"><?php echo __( 'Published date' ); ?></label>
					<input id="page_published_on" name="page[published_on]" size="10" type="text" value="<?php echo $page->published_on ?>" maxlength="20" class="input-text" />
				</p>
			<?php endif; ?>



			<?php Observer::notify( 'view_page_edit_plugins', $page ); ?>

			<!-- /page_edit_settings -->
		</div>

		<!-- /dform-area -->
	</div>


	<p class="dform-buttons">
		<input id="page_edit_commit" class="input-button" name="commit" type="submit" accesskey="s" value="<?php echo __( 'Save and Close' ); ?>" title="<?php echo __( 'Or press' ); ?> Alt+S" />
		<input id="page_edit_continue" class="input-button" name="continue" type="submit" accesskey="e" value="<?php echo __( 'Save and Continue Editing' ); ?>" title="<?php echo __( 'Or press' ); ?> Alt+E" />
		<?php echo __( 'or' ); ?> <a href="<?php echo get_url( 'page' ); ?>" id="page_edit_cancel"><?php echo __( 'Cancel' ); ?></a>
	</p>

	<?php if ( isset( $page->updated_on ) ): ?>
		<p class="page-edit-updated"><small><?php echo __( 'Last updated by <a href=":link">:name</a> on :date', array(':link' => get_url( 'user/edit/' . $page->updated_by_id ), ':name' => $page->updated_by_name, ':date' => date( 'D, j M Y', strtotime( $page->updated_on ) )) ); ?></small></p>
	<?php endif; ?>
</form>

