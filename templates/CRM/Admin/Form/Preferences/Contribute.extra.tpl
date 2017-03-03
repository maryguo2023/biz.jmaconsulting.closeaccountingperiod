{if $period}
<div id="orgs">
  {foreach from=$period item="org" key="id"}
    {foreach from=$org item="date" key="name"}
      <span class="label">{$name}</span>
      <span class="content">{$date}</span>
      <br/>
    {/foreach}
  {/foreach}
</div>
{/if}
{literal}
  <script type="text/javascript">
    CRM.$(function($) {
      showHideElement('financial_account_balance_enabled', 'fiscalYearStart');
      $("#financial_account_balance_enabled").click(function() {
        showHideElement('financial_account_balance_enabled', 'fiscalYearStart');
      });
      function showHideElement(checkEle, toHide) {
        if ($('#' + checkEle).prop('checked')) {
          $("tr.crm-preferences-form-block-" + toHide).show();
        }
        else {
          $("tr.crm-preferences-form-block-" + toHide).hide();
        }
      }
      $("tr.crm-preferences-form-block-prior_financial_period td:nth-child(2)").html($('#orgs'));
    });
  </script>
{/literal}