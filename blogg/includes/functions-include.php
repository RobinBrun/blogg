<!-- function include php scriptet har jag för att definera flera
funktioner som jag kommer att anvämda för att validera user inout
och för att skapa nytt user account eller logga in existing användare -->
<?php
/*
Detta är första funktionen emptyInputSignup som checkar om något av 
input fälterna för signup som är 
name, email, username, passward och repeat passward är toma
Funktionen returnerar true om någon av fälten är tomma och 
annars falskt
*/
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat ){
    $result;
    //Empty är en inbyggd function i php som checkar om det finns data
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        //If mistake, return true
     $result = true;
    }
    else{
        //om det ej finns tomma rutor
        $result = false;
    }
    return $result;
}

/*
 Andra funktionen invalidUid checkar om användarnamnet som användaren har skrivit 
 innehåller andra symboler som inte är bokstäver eller siffror
 funktionen returnerar true om den hittade, och false om det funka
*/
function invalidUid($username){
    $result;
    //preg_match är en sök algoritm 
    if(!preg_match("/^[a-zA-Z0-9]*$/"), $username){
        //Om det finns ett mistake, resultat blir true
     $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}


/*
 Den tredje funktionen invalidEmail checkar om det emailet inskrivet
 av användaren är en valid email eller inte. Som förgående funktioner
 så blir det true om emailet är felaktig, och falsk om den funkar
*/
    function invalidEmail($email){
        $result;
        // FILTER_VALIDATE_EMAIL är en inbyggd function såsom preg_match fast för emails
        //filter är även false pga av jag error söker i koden
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            //Om det finns ett mistake, resultat blir true.
         $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

/*
Fyronde funktionen pwdMatch checkar om lösenordet skriven av användaren
är detsamma som repeat password. Den returnerar true om de inte stämmer
ihop och false om de stämmer.
*/
        function pwdMatch($pwd, $pwdRepeat){
            $result; 
            if($pwd !== $pwdRepeat){
                //Om det finns ett mistake, resultat blir true
             $result = true;
            }
            else{
                $result = false;
            }
            return $result;
        }
        
/*
 Femte funktionen uidExist checkar om en använder med samma användarnamn eller 
 email redan finns i databasen. den tar 3 argument:
 en database connection objekt, användarnamnet för att checka och email
 för att checka. Om en user med samma användarnamn ELLER email finns
 då returnerar funktionen en associative array med användarens information.
 Om ingen user finns med det email eller användarnamn så returnerar
 funktionen false

*/
        function uidExists($conn, $username, $email){
            // SELECT ALLA FRÅN DATABAS users utav columnen usersUid och columnen userEmail som finns i databasen
                                                                   //Första ; är för att stänga igen sql statementet 
                                                                   //och den sista ; för att stänga php koden
            //Använder ? och prepared statements så att jag kan lägga till informationen senare då det är en säkerhetsrisk annars 
            //att direkt skicka in information direkt till databsen pga injectors etc. eftersom att man kan skriva in
            //kod där man skriver in namn och det kan förstöra databasen.
            $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
            //init = initilization en preperad statement
            $stmt = mysqli_stmt_init($conn);
            //Kör sql statementet i stmt(databasen med andra ord) för att se om det finns error
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location: ../blogg_signup.php?error=statementfail");
                exit();
            }

            //Om det inte är något fel, kör på att skicka in juice i databas systemet
            //ss är 2 strings
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            //assoc assosative array, en array där columnerna är namnet i databasen
            //Om jag får in information så kommer detta att bli true
            if($row = mysqli_fetch_assoc($resultData)){
            return $row;
            }
            else{
                $result = false;
                return $result;
            }

            mysqli_stmt_close($stmt);
        }



/*
Det sjätte funktionen createUser skapar ett nytt konto i databsen.
Den tar 4 argument, en datatbase connection object, användarnamnet,
email, username och password. Funktionen insertar användarens 
information inuti databsen och returner true om informationen var 
successful
*/
        function createUser($conn, $name, $email, $username, $pwd){
            //Dessa är det som finns innuti databasen och måste vara i rätt ordning
            $sql = "INSERT INTO users(usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
            //Argument saknas i function 
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location: ../blogg_signup.php?error=statementfail");
                exit();
            }
            //Vi måste även hasha för att om det nu skulle komma in en hacker in i databasen så kommer han att få reda på alla lösenord
            //password_hash är en inbyggd function i php, $pwd är vad som ska hashas, PASSWORD_DEFAULT är algoritmen
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ../blogg_signup.php?error=none");
            exit();
        }


/*
Den 7nde funktionen emptyInputLogin checkar om någon av input fälten
som används vid loggin, som är username och password, är tomma.
Den returnerar true om någon av dessa 2 fälten är tomma och annars
sant
*/

        function emptyInputLogin($username, $pwd){
    $result;
    //Empty är en inbyggd function i php som checkar om det finns data
    if(empty($username) || empty($pwd)){
        //Om det finns ett mistake, resultat blir true
     $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

/*
 åttonde och sista funktionen tack gud. Checkar om antinge username, email 
 och password skriven av användaren matchar en redan existerande användare
 i databasen. om den hittar ett konto med samma information då returnar
 funktionen en associative array med användarens information. Om inget
 matchar så returnerar funktionen falskt.
*/ 
   function loginUser($conn, $username, $pwd){
    //Checka om uid redan finns i databasen
    //2st $usernames eftersom att i sqli statementet så bad vi om antinge username eller email vilket blir grejer i parametrarna
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location: ../blogg_login.php?error=wrongLogin");
        exit();
    }
    //Det hashade lösenordet = datan från databasen med den usern som usern försöker att logga in som 
    //Associtive array då jag använde tidigare $row = mysqli_fetch_assoc($resultData)
    //En associtive array använder inte nummer som siffor utan namn, så namnen på coloumn
    $pwdHashed = $uidExists["usersPwd"];
    //password_verify är en funktion som checkar om variabel 1 som är användarens attempt till lösen, och 2 som är
    //lösenordet ifrån databasen
    $checkPwd = password_verify($pwd, $pwdHashed);
    //Om usern skrev inkorrekt password
    if($checkPwd === false){
        //Skicka tillbaka grabben
        header("location: ../blogg_login.php?error=wrongLogin");
        exit();
    }
    else if ($checkPwd === true){
        //function som i inbyggd i php
        session_start();
        //session variabel som är superglobal
        //Referera till uidExists
        $_SESSION["userid"] = $uidExists["usersId"];
        //                                databasen
        $_SESSION["useruid"] = $uidExists["usersUid"];
                //Skicka grabben till main page
                header("location: ../blogg_index.php");
                exit();
    }
   }
