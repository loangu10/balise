<?php

  function budget_is_alone() {
    $subsidies = select_subsidies(array("budget" => $_GET["budget"]));
    return is_empty($subsidies);
  }

  function check_budget_is_alone() {
    header_if(!budget_is_alone(), 403);
  }

  function is_transferable() {
    $budgets = select_budgets(array("binet" => $GLOBALS["binet"], "term" => $GLOBALS["term"]));
    return is_empty($budgets) && exists_term_binet($GLOBALS["binet"]."/".($GLOBALS["term"] - 1));
  }

  function check_is_transferable() {
    header_if(!is_transferable(), 403);
  }

  before_action("check_csrf_get", array("delete"));
  before_action("check_entry", array("show", "edit", "update", "delete"), array("model_name" => "budget", "binet" => $binet, "term" => $term));
  before_action("check_editing_rights", array("new", "create", "edit", "update", "delete", "transfer", "copy"));
  before_action("create_form", array("new", "create", "edit", "update"), "budget");
  before_action("check_form", array("create", "update"), "budget");
  before_action("check_budget_is_alone", array("edit", "update", "delete"));
  before_action("create_form", array("transfer", "copy"), "budget_transfer");
  before_action("check_form", array("copy"), "budget_transfer");
  before_action("check_is_transferable", array("transfer", "copy"));

  switch ($_GET["action"]) {

  case "index":
    $budgets = array();
    foreach (select_budgets(array_merge($query_array, array("binet" => $binet, "term" => $term)), "date") as $budget) {
      $budgets[] = select_budget($budget["id"], array("id", "label", "amount", "subsidized_amount", "real_amount", "subsidized_amount_granted", "subsidized_amount_used"));
    }
    $waves = array();
    foreach(select_waves(array("binet" => $binet, "term" => $term), "submission_date") as $wave) {
      $waves[] = select_wave($wave["id"], array("id", "amount", "granted_amount", "state", "used_amount", "predicted_amount"));
    }
    break;

  case "new":
    break;

  case "create":
    $budget["id"] = create_budget($binet, $term, $_POST["amount"], $_POST["label"], $_POST["amount"] < 0 ? $_POST["subsidized_amount"] : NULL);
    foreach ($_POST["tags"] as $tag) {
      add_tag_budget($tag, $budget["id"]);
    }
    $_SESSION["notice"][] = "La ligne de budget a été créée avec succès.";
    redirect_to_action("index");
    break;

  case "show":
    $budget = select_budget($budget["id"], array("id", "label", "binet", "amount", "term", "real_amount","subsidized_amount", "subsidized_amount_granted", "subsidized_amount_used"));
    break;

  case "edit":
    break;

  case "update":
    update_budget($budget["id"], $_POST);
    remove_tags_budget($budget["id"]);
    foreach ($_POST["tags"] as $tag) {
      add_tag_budget($tag, $budget["id"]);
    }
    $_SESSION["notice"][] = "La ligne de budget a été mise à jour avec succès.";
    redirect_to_action("show");
    break;

  case "delete":
    delete_budget($budget["id"]);
    $_SESSION["notice"][] = "La ligne de budget a été supprimée avec succès.";
    redirect_to_action("index");
    break;

  case "transfer":
    $budgets = select_budgets(array("binet" => $binet, "term" => $term - 1));
    break;

  case "copy":
    foreach ($_POST["budgets"] as $budget) {
      $budget = select_budget($budget, array("id", "amount", "label", "subsidized_amount"));
      $new_budget = create_budget($binet, $term, $budget["amount"], $budget["label"], $budget["subsidized_amount"]);
      foreach (select_tags_budget($budget["id"]) as $tag) {
        add_tag_budget($tag, $new_budget);
      }
    }
    if (!is_empty($_POST["budgets"])) {
      $_SESSION["notice"][] = "Les lignes de budget ont été recopiées avec succès.";
    }
    redirect_to_action("index");
    break;

  default:
    header_if(true, 403);
    exit;
  }
