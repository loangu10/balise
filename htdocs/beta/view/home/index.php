<div id="home-wrapper">
  <?php
  // TODO define news and how to store/get them
  foreach (array() as $news) {
    ?>
    <div class="flashcard opanel news alert alert-dismissible fade in">
      <button class="close" data-dismiss="alert">
        <i class="fa fa-fw fa-close"></i>
      </button>
      <h1><?php echo $news["title"]; ?></h1>
      <p>
        <?php echo $news["content"]; ?>
      </p>
      <div class="controls">
        <?php
        foreach ($news["controls"] as $control) {
          ?>
          <span class="ctrl"><i class="fa fa-fw <?php echo $control["icon"]; ?> bt"></i><span class="which-action"><?php echo $control["name"]; ?></span></span>
          <?php
        }
        ?>
      </div>
    </div>
    <?php
  }
  ?>

  <?php
    $binet_admins = binet_admins_current_student();
    foreach($binet_admins as $binet_admin) {
      $binet_admin["binet_name"] = select_binet($binet_admin["binet"], array("name"))["name"];
      echo link_to(
        path("", "binet", binet_term_id($binet_admin["binet"], $binet_admin["term"])),
        "<div class=\"spot opanel\">
          <div class=\"binet-name\">".$binet_admin["binet_name"]."</div>
          <div class=\"binet-term\">".$binet_admin["term"]."</div>
        </div>",
        array("goto"=>true)
      );
    }
    if (empty($binet_admins)) {
    echo "<p>
      Vous n'avez pas de binets pour le moment ...
      </p>";
    }
  ?>
  <div id="homelinks" class="opanel0">
    <?php
      echo link_to(
        path("",""),
        "<div>   <i class=\"fa-fw fa fa-money\"></i>  Liste des subventions </div>",
        array("class" => "homelink", "id" => "subsidies","goto" => "true" ));
      ?>
    <?php
      echo link_to(
        path("",""),
        "<div>   <i class=\"fa-fw fa fa-group\"></i>  Liste des binets </div>",
        array("class" => "homelink", "id" => "binets","goto" => "true" ));
      ?>
  </div>
</div>
