{extends file='static_/layout.tpl'}
{block name='body'}
<script type="text/javascript" src="/lib/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/lib/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/lib/jquery.simpletip-1.3.1.min.js"></script>
<script type="text/javascript" src="/js/index/punchcard.js"></script>
<div class='search_box'>
    <form method='get'>
	<input tabindex="1" size='60' type='text' name='text' value='{if isset($smarty.get.text)}{$smarty.get.text|escape}{/if}' id='search_text'/>
	{select etc='tabindex="2"' array=$type_options selected=$smarty.get.type|default:1 name='type'}
	{*<select name='group'><option value='host'>Grupuj hosty</option><option value='file'>Grupuj pliki</option></select>*}
	<input type='submit' value='Szukaj'/>
    </form>
</div>

{if isset($files)}
    {foreach from=$files item='group' }
	<div>
	    <span style='cursor: pointer;' class='group_header' data-ip="{$group['header']}">
		<a href='ftp://{$group['header']}'>{$group['header']}</a>
		<img style='height: 14px;' src='/img/timecard.png'/>
	    </span>
	    <div class='group_content'>
		{foreach $group['files'] as $file name='filelist'}
		    <div class='element {if $file['active']==FALSE}inactive{/if} {if ($smarty.foreach.filelist.iteration%2)==1}odd{/if}'>
			<span class='link'><a href='ftp://{$file['host']}{$file['path']}'>ftp://{$file['host']}{$file['path']|escape}</a><a href='ftp://{$file['host']}{$file['path']|escape}{$file['name']|escape}'><span class='bold'>{$file['name']}</span></a></span>
			<span class='size'>{$file['size']|filesize}</span>
		    </div>
		{/foreach}
	    </div>
	</div>
    {foreachelse}
	<div style='text-align: center;'>
	    Nie znaleziono plików<br/>
	    <img src='/img/notfound.png'/>
	</div>
    {/foreach}
{elseif isset($searches)}
    <script type="text/javascript" src="/js/index/bottom_cycle.js"></script>

    <div class='recent_search_box'>
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
		    <a href='/?text={$search[0]|escape:'url'}&type={$search[1]}&group={$search[2]}&hide=true'>
			{$search[0]|escape} - {$type_options[$search[1]]}
		    </a><br/>
		</div>
	    {/foreach}
	</div>
	<div style='width: 900px;'>
	    <span class='title'>Ostatnio dodane filmy</span><br/>
	    {foreach from=$new_movies item='movie'}
		<div class='element'>
		    <a href='/?text={$movie['name']|escape:'url'}&type=movie&group=host'>
			{$movie['name']|escape} : {$movie['size']|filesize}
		    </a><br/>
		</div>
	    {/foreach}
	</div>
    </div>
{/if}
{/block}
