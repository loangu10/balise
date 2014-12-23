<h1>Etudier la demande de subvention</h1>
<form role="form" id="request" action="<?php echo path("grant", "request", $request["id"], binet_prefix($binet, $term)); ?>" method="post">
  <?php
    foreach (subsidies_involved() as $subsidy) {
      echo form_group_text("Montant accordé pour ".pretty_subsidy($subvention["id"])." :", adds_amount_prefix($subsidy), $request);
      echo form_group_text("Explication pour le montant accordé à ".pretty_subsidy($subvention["id"])." :", adds_purpose_prefix($subsidy), $request);
    }
  ?>
  <?php echo form_csrf_token(); ?>
  <?php echo form_submit_button("Enregistrer"); ?>
</form>
