<?php

  function check_admin() {
    header_if(!validate_input(array("admin")), 400);
    $terms = select_terms(array("student" => $_GET["admin"], "binet" => $GLOBALS["binet"], "term" => $GLOBALS["term"]));
    header_if(is_empty($terms), 404);
    $GLOBALS["admin"] = $_GET["admin"];
  }

  before_action("check_csrf_post", array("create"));
  before_action("check_csrf_get", array("delete"));
  before_action("check_admin", array("delete"));
  before_action("current_kessier", array("new", "create", "delete"));
  before_action("check_form_input", array("create"), array(
    "model_name" => "admin",
    "int_fields" => array(array("term", 1)),
    "other_fields" => array(array("student", "exists_student")),
    "redirect_to" => path("new", "admin", "", binet_prefix($binet, $term)),
    "optional" => array("term")
  ));
  before_action("generate_csrf_token", array("new", "index"));

  $form_fields = array("term", "student");

  switch ($_GET["action"]) {

  case "index":
    break;

  case "new":
    $admin = initialise_for_form_from_session($form_fields, "admin");
    break;

  case "create":
    $admin_term = current_term($binet) + $_POST["term"];
    add_admin_binet($_POST["student"], $binet, $admin_term);
    send_email($_POST["student"], "Nouveau binet", "new_admin", array("binet_term" => $binet."/".$admin_term));
    $_SESSION["notice"][] = pretty_student($_POST["student"])." est à présent administrateur du binet ".pretty_binet($binet)." pour la promotion ".$admin_term.".";
    redirect_to_action("");
    break;

  case "delete":
    remove_admin_binet($admin, $binet, $term);
    $_SESSION["notice"][] = "Les droits d'administration de ".pretty_student($admin)." pour la promotion ".$term." du binet ".pretty_binet($binet)." ont été révoqués.";
    redirect_to_action("");
    break;

  default:
    header_if(true, 403);
    exit;
  }
