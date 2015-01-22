<?php $budget = select_budget($budget, array("id", "label", "binet", "amount", "term", "real_amount", "subsidized_amount_requested", "subsidized_amount_granted", "subsidized_amount_used")); ?>
<script src = "<?php echo ASSET_PATH; ?>js/show-budget.js"></script>
<div class="show-container">
  <div class="sh-title">
    <div class="logo">
      <i class="fa fa-5x <?php echo $budget["amount"] > 0 ? "fa-plus-circle" : "fa-minus-circle"; ?>"></i>
    </div>
    <div class="text">js
      <p class="main">
        <?php echo $budget["label"]; ?>
      </p>
      <p class="sub">
        <?php echo pretty_binet_term($budget["binet"]."/".$budget["term"]); ?>
      </p>
    </div>
  </div>
  <div class="sh-bu-ratio">
    <div class="header">
      Budget réel / prévisionnel
    </div>
    <div>
      <div class="used" id="real_budget">
        <?php echo ratio_bar($budget["real_amount"], $budget["amount"]); ?>
      </div>
    </div>
  </div>
  <div class="sh-bu-ratio">
    <div class="header">
      Subventions utilisées / accordées
    </div>
    <div>
      <div class="used" id="subsidies">
        <?php echo ratio_bar($budget["subsidized_amount_used"], $budget["subsidized_amount_granted"]); ?>
      </div>
    </div>
  </div>
  <div class="sh-bu-tags">
    <?php echo pretty_tags(select_tags_budget($budget["id"])); ?>
  </div>
</div>
