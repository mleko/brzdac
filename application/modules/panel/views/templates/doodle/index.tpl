{extends file='static_/layout.tpl'}
{block name='mainmenu' prepend}
	{assign main_menu_active "doodle"}
{/block}
{block name='body'}
	<script type="text/javascript" src="/lib/jquery.simpletip-1.3.1.min.js"></script>
	<script src='/js/panel/doodle/index.js'></script>


	<form method='post' action='/panel/doodle' enctype="multipart/form-data">
		<div>
			<input type="hidden" name='doodle_id' value="{$edit['id']|default:0}"/>
			Opis:<input name='description' value="{$edit['description']|default:''}"/>
			Start:<input id='date-start' name="start" value="{$edit['start']|default:''}"/>
			End:<input id='date-end' name="end" value="{$edit['end']|default:''}"/>
			Obrazek:<input type="file" name='file'/>
			{if $edit['id']|default:0}
				<input type='image' src='/img/icons/16x16/check_mark.png'/>
				<a href='/panel/doodle'><img src='/img/icons/16x16/page.png' /></a>
				{else}
				<input type='image' src='/img/icons/16x16/plus.png'/>
			{/if}
		</div>
	</form>


	{if isset($doodles) && $doodles}
		<table style='width: 100%;'>
			<tr>
				<td></td>
				<td>ID</td>
				<td>Opis</td>
				<td>Start</td>
				<td>End</td>
				<td>Status</td>
				<td>Obrazek</td>
			</tr>
			{foreach $doodles as $doodle}
				<tr>
					<td>
						<a href="/?debug_doodle={$doodle['id']}">
							<img src='/img/icons/16x16/info.png' alt='info'/>
						</a>
						<a href="/panel/doodle/{$doodle['id']}/edit">
							<img src='/img/icons/16x16/pencil.png' alt='edit'/>
						</a>

						{if $doodle['enabled']==1}
							<a href="/panel/doodle/{$doodle['id']}/disable"><img src='/img/icons/16x16/close.png' alt='disable'/></a>
							{else}
							<a href="/panel/doodle/{$doodle['id']}/enable"><img src='/img/icons/16x16/check_mark.png' alt='enable'/></a>
							{/if}
					</td>
					<td>{$doodle['id']}</td>
					<td>{$doodle['description']}</td>
					<td>{$doodle['start']}</td>
					<td>{$doodle['end']}</td>
					<td>
						{if $doodle['enabled']==1}
							<span style='color: #22e;'>Aktywny</span>
						{else}
							Nie-Aktywny
						{/if}
					</td>
					<td><span data-image="{$doodle['file_id']}-{$doodle['name']}"><img src='/img/icons/16x16/photo.png'/></span></td>
				</tr>

			{/foreach}
		</table>
	{else}
		Brak doodles
	{/if}

{/block}
