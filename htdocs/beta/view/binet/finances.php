<div class="row">
  <div class="col-lg-3">
  </div>
  <div class="col-lg-6">
    <?php echo fuzzy_input();?>
  </div>
  <div class="col-lg-3">
    <div class="switch opanel">
      <?php
      $active = "active";
      $inactive = "inactive";
      if ($budget_view) {
        $budget_class = $active;
        $operation_class = $inactive;
      } else {
        $budget_class = $inactive;
        $operation_class = $active;
      }
      ?>
      <span class="left component <?php echo $budget_class; ?> ">
        <?php echo link_to(path("index", "budget", "", binet_prefix($binet, $term)), "Budget",array("class" => $budget_class)); ?>
      </span>
      <span class="right component <?php echo $operation_class; ?>">
        <?php echo link_to(path("index", "operation", "", binet_prefix($binet, $term)), "Opérations",array("class" => $operation_class)); ?>
      </span>
    </div>
  </div>
</div>
<div class="row-centered">
  <div class="col-max">
    <h2 class="tabtitle"><?php echo $table_title; ?></h2>
    <div class="table-responsive" id="operations-table">
      <table class="table table-bordered table-hover table-small-char">
        <?php echo $table; ?>
      </table>
    </div>
  </div>
</div>
<?php echo fuzzy_load_scripts("",""); ?>