{extends file='static_/layout.tpl'}
{block name='mainmenu' prepend}
	{assign main_menu_active "wishlist"}
{/block}
{block name='body'}
	<script src='/js/panel/wish/index.js'></script>

	<span id='make-a-wish' style='text-decoration: underline;'>Make a wish</span>
	<div id='wish-form'>
		<form  method='post' >
			<textarea style='width: 100%; height: 10em;' name='wish'></textarea>
			<input type='submit'/>
		</form>
	</div>
	{if $wishes}
		<div class='wishes'>
			{foreach $wishes as $wish}
				<div class='wish'>
					<a href='/panel/wish/{$wish['wishId']}/details'>{$wish['wish']}</a>
					<div class='wish-footer'>
						{if $wish['user']}{$wish['user']} @ {/if}{$wish['ip']} - {$wish['date']} | {$wish['commentCount']} komentarz(e/y)
					</div>
				</div>
			{/foreach}
		</div>
	{else}
		<p>There are no wishes</p>
	{/if}

{/block}
