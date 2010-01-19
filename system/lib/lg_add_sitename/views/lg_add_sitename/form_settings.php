<?php print $DSP->form_open( array('action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings'), array('name' => strtolower(get_class($this))));?>

<div class="tg">
	<h2><?php print str_replace("{addon_name}", $this->name, $LANG->line("enable_extension_title")); ?></h2>
	<table>
		<tbody>
			<tr class="even">
				<th>
					<?php print str_replace("{addon_name}",  $this->name, $LANG->line("enable_extension_label")); ?>
				</th>
				<td>
					<?php print $this->select_box(
						$settings['enable'],
						array("y" => "yes", "n" => "no"),
						"enable");
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="tg">
	<h2><?php print $LANG->line("cp_branding_title"); ?></h2>
	<div class="info">
		<?php print $LANG->line('cp_branding_info');?>
		<?php print $LANG->line("enable_super_replacements_info"); ?>
	</div>
	<table>
		<tbody>
			<tr class="even">
				<th scope="row"><?php print $LANG->line('cp_branding_xhtml_label'); ?></th>
				<td><?php print $DSP->input_textarea('xhtml', $settings['xhtml'], 5, 'textarea', '99%'); ?></td>
			</tr>
			<tr class="even">
				<th>
					<?php print $LANG->line("enable_super_replacements_label"); ?>
				</th>
				<td>
					<?php print $this->select_box(
						$settings['enable_super_replacements'],
						array("y" => "yes", "n" => "no"),
						"enable_super_replacements");
					?>
				</td>
			</tr>
			<tr class="odd">
				<th scope="row"><?php print $LANG->line('cp_branding_css_label'); ?></th>
				<td><?php print $DSP->input_textarea('css', $settings['css'], 15, 'textarea', '99%'); ?></td>
			</tr>
			<tr class="even">
				<th scope="row"><?php print $LANG->line('cp_branding_show_time_label'); ?></th>
				<td>
					<?php print $this->select_box(
						$settings['show_time'],
						array("y" => "yes", "n" => "no"),
						"show_time");
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="tg">
	<h2>HTML source additions</h2>
	<div class="info">
		HTML source additions are added at specific points of the CP HTML. This feature allows you to add custom JS libraries, CSS or other HTML.
	</div>
	<table>
		<tbody>
			<tr class="even">
				<th scope="row">
					<?php print $LANG->line("head_additions_label");?>
					<div class="note"><?php print $LANG->line("head_additions_info");?></div>
				</th>
				<td><?php print $DSP->input_textarea('head_additions', $settings['head_additions'], 5, 'textarea', '99%'); ?></td>
			</tr>
			<tr class="odd">
				<th scope="row">
					<?php print $LANG->line("body_additions_label");?>
					<div class="note"><?php print $LANG->line("body_additions_info");?></div>
				</th>
				<td><?php print $DSP->input_textarea('body_additions', $settings['body_additions'], 5, 'textarea', '99%'); ?></td>
			</tr>
			<tr class="even">
				<th scope="row">
					<?php print $LANG->line("foot_additions_label");?>
					<div class="note"><?php print $LANG->line("foot_additions_info");?></div>
				</th>
				<td><?php print $DSP->input_textarea('foot_additions', $settings['foot_additions'], 5, 'textarea', '99%'); ?></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="tg">
	<h2><?php print $LANG->line("page_title_title"); ?></h2>
	<div class="info"><?php print $LANG->line('page_title_title_info'); ?></div>
	<table>
		<tbody>
			<tr class="even">
				<th scope="row"><?php print $LANG->line('page_title_enable_label'); ?></th>
				<td>
					<?php print $this->select_box(
						$settings['enable_page_title_replacement'],
						array("y" => "yes", "n" => "no"),
						"enable_page_title_replacement");
					?>
				</td>
			</tr>
			<tr class="odd">
				<th scope="row"><?php print $LANG->line("page_title_value_label"); ?></th>
				<td><?php print $DSP->input_text('page_title_replacement_value', $settings['page_title_replacement_value']); ?></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="tg">
	<h2><?php print $LANG->line("check_for_updates_title") ?></h2>
	<div class="info"><?php print str_replace("{addon_name}", $this->name, $LANG->line("check_for_updates_info")); ?></div>
	<table>
		<tbody>
			<tr class="odd">
				<th><?php print  $LANG->line("check_for_updates_label") ?></th>
				<td>
					<select<?php if(!$lgau_enabled) : ?> disabled="disabled"<?php endif; ?> name="check_for_updates">
						<option value="y"<?php print ($settings["check_for_updates"] == "y" && $lgau_enabled === TRUE) ? 'selected="selected"' : ''; ?>>
							<?php print $LANG->line("yes") ?>
						</option>
						<option value="n"<?php print ($settings["check_for_updates"] == "n" || $lgau_enabled === FALSE) ? 'selected="selected"' : ''; ?>>
							<?php print $LANG->line("no") ?>
						</option>
					</select>
					<?php if(!$lgau_enabled) : ?>
						&nbsp;
						<span class='highlight'>LG Addon Updater is not installed and activated.</span>
						<input type="hidden" name="check_for_updates" value="0" />
					<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<input type="submit" value="<?php print $LANG->line('save_extension_settings') ?>" />

</form>