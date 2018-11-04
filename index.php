<!--  index.php
//  This is a complex PHP program that reads a gift list from an xml file and allows the user to add items to their gift list.  I also added the ability for the user to delete all the items off their gift list, have the option to delete one line at a time, and add who the gift is for.
//  Created by Daniel on 11/4/18
//  The purpose of this program was to demonstrate the differences and similarites between Perl, Python, and PHP by writing the same program that was written in Perl and Python, in PHP.
// To run this program start your MAMP/LAMP/WAMP server and type in the address to this file with the file name.  For example: http://localhost:8888/danielbutton_complex_php/danielbutton_complex.php .  Be sure the file is in the right location and that snowman.jpg and list.xml is included in the same directory -->

<!-- Set up the basic HTML format -->

<HTML>
<HEAD>

<!-- Added CSS styling -->

<style>
body {
    background-image: url("snowman.jpg");
}
#main {
    position:fixed;
    top: 30%;
    left: 54%;
    width:20em;
    height:35em;
    margin-top: -9em;
    margin-left: -15em;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #f3f3f3;
}

#count {
    color: white;
    font-size: 20px;
}

#list {
    background: white;
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 27px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
}
</style>

</HEAD>
<BODY>

<!-- Initiated PHP code -->

<?php

    echo <<<_END
    <h1 style='color: white;'>PHP Holiday Budget App 3.0</h1>
    
    <form onsubmit='setBudget()' method='post'>
    <label style="color: white; font-size: 20px;">Your Budget: $</label>
    <input id="amount" style='width: 10%; font-size: 20px;' type='number' name='item' placeholder='ex: 12'>
    <input class='button' style='background-color: grey;' type='submit' value='Set Budget' name='budget'>
    </form>
    
    <span style="color: white; font-size: 30px;">Budget remaining: $<span id="result"></span>.00</span>
_END;
    
    // Calling the countList function to display number of items in list.xml
    
    echo "<div id='count'>";
    countList();
    echo "</div>";
    
    echo <<<_ENDTWO
    <div id='main'>
    
    <p><i>Add the presents you need to buy for the holiday season.</i></p>
    
    <form onsubmit='danielbutton_complex.php' method='post'>
    Gift: <input style='width: 100%; font-size: 20px;' type='text' name='item' placeholder='ex: necktie'>
    Who is this present for: <input type='text' style='width: 100%; font-size: 20px;' type='text' name='who' placeholder='ex: Dad'>
    Cost: <input id="price" style='width: 100%; font-size: 20px;' type='number' name='cost' placeholder='ex: 12'>
    <input class='button' type='submit' value='Add' name='submit'>
    </form>
    
    <p style='text-align: center;'> <b>Presents to Buy</b> </p>

_ENDTWO;
    
    // This is where the list will show up
    
    echo "<div id='list'>";
    showList();
    echo "</div>";
    
    echo <<<_ENDTHREE
    <br><br>
    
    <form style='text-align: center;' onsubmit='danielbutton_complex.php' method='post'>
    <input class='button' style='background-color: #f44336;' type='submit' name='deleteAll' value='Delete Entire List'>
    </form>
    
    </div>
_ENDTHREE;
    
    // Function to count the number of items in list.xml.  Do note Xcode adds a blank line to xml files which is why I subtracted 1 from the line count.  If a user's machine does not do this as well, the numbers will be off!
    
    function countList() {
        $lines = count(file('list.xml'));
        $no_of_items = $lines - 1;
        if ($no_of_items < 0) {
            echo "You have 0 presents on your gift list.";
        } else {
            echo "You have $no_of_items presents on your gift list.";
        }
    }
    
    // Function to read and display list.xml
    
    function showList()
    {
        $myfile = fopen("list.xml", "r") or die("Unable to open file!  Please make sure list.xml is in the same folder");
        $list = fread($myfile,filesize("list.xml"));
        echo nl2br($list);
        fclose($myfile);
    }
    
    // Function to add items to list.xml
    
    function addItem()
    {
        $myfile2 = fopen("list.xml", "a") or die("Unable to open file!");
        $txt = "\r\n" . $_POST["item"] . "&nbsp;&nbsp;" . "for" . "&nbsp;&nbsp;" . $_POST["who"] . "&nbsp;&nbsp;" . "which costs" . "&nbsp;&nbsp;$" . $_POST["cost"] . ".00";
        fwrite($myfile2, $txt);
        fclose($myfile2);
        
        $cost = $_POST["cost"];
        
        // JS Function that subtracts the cost of the gift from budget
        
        echo <<<_JSF
        <script type="text/javascript">
        function subtractBudget() {
            var original = localStorage.getItem("budget");
            var price = $cost;
            var newBudget = parseInt(original) - parseInt(price);
            localStorage.setItem("budget", newBudget);
        }
        subtractBudget();
        </script>
_JSF;
        header("Refresh:0");
    }
    if(isset($_POST['submit']))
    {
        addItem();
    }
    
    // function to delete all items from list.xml
    
    function deleteAll()
    {
        $myfile3 = fopen("list.xml", "w") or die("Unable to open file!");
        $txt = "";
        fwrite($myfile3, $txt);
        fclose($myfile3);
        header("Refresh:0");
    }
    if(isset($_POST['deleteAll']))
    {
        deleteAll();
    }
    
    ?>

<!-- End of PHP -->

</BODY>

<!-- JS Functions to set budget in localStorage so when page refreshes budget will remain -->

<script>
function setBudget() {
    var budgetValue = document.getElementById("amount").value;
    localStorage.setItem("budget", budgetValue);
    // Retrieve
}

function showBudget() {
    document.getElementById("result").innerHTML = localStorage.getItem("budget");
}

showBudget();

</script>

</HTML>

<!-- End of program -->
