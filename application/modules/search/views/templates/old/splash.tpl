{extends file='static_/layout.tpl'}
{block name='body'}
	<script type="text/javascript" src="/lib/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="/lib/jquery.cycle.all.js"></script>
	<div class='search_box'>
		<form method='get'>
			<input tabindex="1" size='60' type='text' name='text' value='{if isset($smarty.get.text)}{$smarty.get.text|escape}{/if}' id='search_text'/>
			{select etc='tabindex="2"' array=$type_options selected=$smarty.get.type|default:1 name='type'}
			<input type='submit' value='Szukaj'/>
		</form>
	</div>

	{if isset($searches)}
		<script type="text/javascript" src="/js/index/bottom_cycle.js"></script>

		<div class='recent_search_box'>
			{if isset($doodle)}
				<div style='width: 900px;'>
					<span class='title'>{$doodle['description']|default}</span><br/>
					<img height='300' src='/img/doodle/{$doodle['file_id']}-{$doodle['name']}'/>
				</div>
			{/if}
			{*
			<div style='width: 900px;'>
			<span class='title'>Wesołych Świąt i Szczęśliwego Nowego Roku</span><br/>
			<img height='300' src='/img/xmas_cat.png'/>
			</div>
			*}
			<div style='width: 900px;'>
				<span class='title'>Ostatnio szukane</span><br/>
				{foreach from=$searches item='search'}
					<div class='element'>
						<a href='?text={$search['text']|escape:'url'}&type={$search['type']}&hide=true'>
							{$search['text']|escape} - {$type_options[$search['type']]}
						</a><br/>
					</div>
				{/foreach}
			</div>
			<div style='width: 900px;'>
				<span class='title'>Ostatnio dodane filmy</span><br/>
				{foreach from=$new_movies item='movie'}
					<div class='element'>
						<a href='?text={$movie['name']|escape:'url'}&type=1'>
							{$movie['name']|escape} : {$movie['size']|filesize}
						</a><br/>
					</div>
				{/foreach}
			</div>
		</div>
	{/if}
{/block}
