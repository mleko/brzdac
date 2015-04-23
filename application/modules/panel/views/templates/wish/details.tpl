{extends file='static_/layout.tpl'}
{block name='mainmenu' prepend}
	{assign main_menu_active "wishlist"}
{/block}
{block name='body'}
	<div class='wish'>
		{$wish['wish']}
		<div class='wish-footer'>
			{if $wish['user']}{$wish['user']} @ {/if}{$wish['ip']} - {$wish['date']}
		</div>
	</div>
	{if $comments}
		{foreach $comments as $comment}
			<div class='wish'>
				{$comment['text']}
				<div class='wish-footer'>
					{if $comment['user']}{$comment['user']} @ {/if}{$comment['ip']}
				</div>
			</div>
		{/foreach}
	{else}
		Brak komentarzy
	{/if}
	<form method='post'>
		<textarea name='comment' style='width: 100%; height: 10em;'></textarea>
		<input type='submit'/>
	</form>
{/block}