<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <!-- Choose binet using dropdown menu -->
    <li>
      <!-- For all binets -->
      <a href="javascript:;" data-target="#binets" data-toggle="collapse"><?php echo pretty_binet_no_link($binet)?> </a>
      <ul id="binets" class="collapse">
        <?php foreach(binet_admins_current_student() as $binet_admin) {
          $binet_admin["binet_name"] = select_binet($binet_admin["binet"], array("name"))["name"];
          ?>
          <li>
            <?php echo link_to(path("", "binet", binet_term_id($binet_admin["binet"], $binet_admin["term"])), $binet_admin["binet_name"]." <span class=\"binet-term\">".$binet_admin["term"]."</span>"); ?>
          </li>
          <?php
        }
        ?>
      </ul>
    </li>
    <!-- Accueil : links to budget/operations page -->
    <?php
    echo li_link(
      link_to(path("", "budget", "", binet_prefix($binet, $term)), "<i class=\"fa fa-fw fa-home\"></i> Accueil"),
      $_GET["controller"] == "budget" || $_GET["controller"] == "operation"
    );
    $number_pending_validations = count_pending_validations($binet, $term);
    echo li_link(
      link_to(
        path("", "validation", "", binet_prefix($binet, $term)),
        "<i class=\"fa fa-fw fa-check\"></i> Validations".($number_pending_validations > 0 ? " <span class=\"counter\">".$number_pending_validations."</span>" : "")
      ),
      $_GET["controller"] == "validation"
    );
    echo li_link(
      link_to(path("", "request", "", binet_prefix($binet, $term)), "<i class=\"fa fa-fw fa-money\"></i> Subventions"),
      $_GET["controller"] == "request"
    );
    // If subsidy provider
    if (select_binet($binet, array("subsidy_provider"))["subsidy_provider"] == 1) {
      ?>
        <li class="divider"></li>
      <?php
      echo li_link(
      link_to(path("", "wave", "", binet_prefix($binet, $term)), "<i class=\"fa fa-fw fa-star\"></i> Vague de subventions"),
        $_GET["controller"] == "wave"
      );
    }
    if ($binet == KES_ID) {
      ?>
        <li class="divider"></li>
      <?php
      echo li_link(
        link_to(path("admin", "binet"), "<i class=\"fa fa-fw fa-desktop\"></i> Administration"),
        $_GET["controller"] == "admin"
      );
    }
  ?>
</ul>
</div>
