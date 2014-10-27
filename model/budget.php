<?php

  function create_budget($binet, $term, $amount, $label) {
    $values["binet"] = $binet;
    $values["term"] = $term;
    $values["amount"] = $amount;
    $values["label"] = $label;
    return create_entry(
      "budget",
      array("binet", "term", "amout"),
      array("label"),
      $values
    );
  }

  function select_budget($budget, $fields = NULL) {
    return select_entry("budget", $budget, $fields);
  }

  // TODO: selection by subsidied_amount, real_amount
  function select_budgets($criteria, $order_by = NULL, $ascending = true) {
    return select_entries("budget",
                          array("binet", "amount", "term"),
                          array(),
                          $criteria,
                          $order_by,
                          $ascending);
  }

  function update_budget($budget, $hash) {
    update_entry("budget",
                  array("amount"),
                  array("label"),
                  $budget,
                  $hash);
  }

  function get_real_amount_budget($budget) {
    $sql = "SELECT SUM(operation_budget.amount) as real_amount
            FROM operation_budget
            INNER JOIN operation
            ON operation.id = operation_budget.operation
            WHERE operation_budget.budget = :budget AND operation.kes_validation_by != NULL";
    $req = Database::get()->prepare($sql);
    $req->bindParam(':budget', $budget, PDO::PARAM_INT);
    $req->execute();
    return $req->fetch(PDO::FETCH_ASSOC)["real_amount"];
  }

  function get_subsidized_amount_budget($budget) {
    $sql = "SELECT SUM(subsidy.granted_amount) as subsidized_amount
            FROM subsidy
            INNER JOIN request
            ON request.id = subsidy.request
            INNER JOIN wave
            ON wave.id = request.wave
            WHERE wave.published = 1 AND subsidy.budget = :budget";
    $req = Database::get()->prepare($sql);
    $req->bindParam(':budget', $budget, PDO::PARAM_INT);
    $req->execute();
    return $req->fetch(PDO::FETCH_ASSOC)["subsidized_amount"];
  }
