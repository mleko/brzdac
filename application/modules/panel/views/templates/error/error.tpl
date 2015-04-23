<div style='text-align: center;'>
    <div>{$this->message}</div><br/>
    <img src='/img/{$this->img}.jpg'/>


    {if $this->exception}
	<div style='display: none;'>
	    <h3>
		Exception information:
	    </h3>

	    <p>
		<b>Message:</b> {$this->exception->getMessage()}
	    </p>

	    <h3>
		Stack trace:
	    </h3>

	    <pre>{$this->exception->getTraceAsString()}
	    </pre>

	    <h3>
		Request Parameters:
	    </h3>

	    <pre>{var_export($this->request->getParams(), true)}
	    </pre>
	</div>
    {/if}
</div>