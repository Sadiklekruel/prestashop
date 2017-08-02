<li>
  <a href="{$base_dir}modules/blog/blog_page.php" title="{l s='Click this link' mod='blog'}">{l s='Click me!' mod='blog'}</a>
</li>
<!-- Block blog -->
<div id="blog_block_left" class="block">
  <h4>{l s='Welcome!' mod='blog'}</h4>
  <div class="block_content">
    <p>
      {if !isset($my_module_name) || !$my_module_name}
        {capture name='my_module_tempvar'}{l s='World' mod='blog'}{/capture}
        {assign var='my_module_name' value=$smarty.capture.my_module_tempvar}
      {/if}
      {l s='Hello %1$s!' sprintf=$my_module_name mod='blog'}
    </p>
    <ul>
      <li><a href="{$my_module_link}"  title="{l s='Click this link' mod='blog'}">{l s='Click me!' mod='blog'}</a></li>
    </ul>
    <p>Produits actuellement disponible : <b>{$my_module_total}</b></p>
  </div>
</div>
<!-- /Block blog -->
