<?php

namespace Actions\Category;

class ListCategoryAction
{
    public function __construct()
    {

    }

    function action($db, $user): string
    {
        $output = '';
        $query = $db->prepare('SELECT category_id, name FROM Category order by name');
        $query->execute();
        $categories = $query->fetchAll();

        if ($categories) {
            foreach ($categories as $category) {

                $output .= '<option value="' . $category['category_id'] . '":>' . $category['name'] . '</option>';
            }
        } else {
            //Brak Slownika Gatunkow
        }
        return $output;
    }
}