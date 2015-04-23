{extends file='static_/layout.tpl'}
{block name='mainmenu' prepend}
	{assign main_menu_active "types"}
{/block}
{block name='body'}

	<form method='post'>
		{foreach $fileTypes as $type}
			<div>
				<input style='width: 15%;' type='text' value='{$type['name']|default:''}' name='name[{$type['id']|default:0}]'/>
				<input style='width: 83%;' type='text' value='{$type['extensions']|default:''}' name='extensions[{$type['id']|default:0}]'/><br/>
			</div>
		{/foreach}
		<input type='submit' value='Zapisz'/>
	</form>
{/block}
