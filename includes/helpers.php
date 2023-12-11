<?php

/**
 * Looks for a $value from an $attribute’s column in a $table, returning true if
 * found, false if not. For example, if a value named “stairway to heaven”
 * exists under an attribute called “name” within a table called “songs,” then
 *
 *    valueExistsInAttribute("stairway to heaven", "name", "songs")
 *
 * would return true.
 *
 * @param $value      The query I’m interested in finding.
 * @param $attribute  The attribute under which I would like to locate $value.
 * @param $table      The table containing the $attribute.
 *
 * @access public
 * @return bool|void
 */
function valueExistsInAttribute($value, $attribute, $table) {
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=" . DBHOST . "; dbname=" . DBNAME . ";charset=utf8",
            DBUSER,
            DBPASS
        );

        $statement = $db -> prepare("SELECT $attribute FROM $table");
        $statement -> execute();

        $found = false;

        while (($row = $statement -> fetch())) {
            if ($value == $row[$attribute]) {
                $found = true;

                break;
            }
        }

        $statement = null;

        return $found;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function " .
            "<code>valueExistsInAttribute</code> has generated the " .
            "following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

/**
 * Returns one $value — or the first, if more than one is retrieved — from a
 * $table if a $query should match a $pattern. For example, imagine you want the
 * album name from an album table whose artist ID is 2:
 *
 *    $album = select("album_name", "album", "artist_id", "2");
 *
 * @param $value   The attribute I want to retrieve
 * @param $table   The table in which the attribute resides
 * @param $query   The query I want to match
 * @param $pattern The pattern that the query should match
 *
 * @access public
 * @return false|mixed|void
 */
function getValue($value, $table, $query, $pattern) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);

        $statement = $db ->
            prepare("SELECT $value FROM $table WHERE $query = :q");

        $statement -> execute(array('q' => $pattern));

        $row = $statement -> fetch();

        $statement = null;

        if ($row === false) {
            $result = false;
        } else {
            $result = $row[$value];
        }

        return $result;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>getValue</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

/**
 * Updates the $current_attribute in a $table to a $new_attribute based on
 * whether $query_attribute matches $pattern. For example, if you wanted to
 * update the album name of Warpaint’s Heads Up to HEADS UP, you would use this
 * function as follows:
 *
 *    update("album", "album_name", "HEADS UP", "album_name", "Heads Up");
 *
 * @param $table             The table holding the attribute to update
 * @param $current_attribute The current attribute that will be updated
 * @param $new_attribute     The new attribute that will replace the current
 *                             attribute
 * @param $query_attribute   The attribute to be queried
 * @param $pattern           The pattern the query attribute will need to match
 *
 * @access public
 * @return void
 */
function updateAttribute($table, $current_attribute, $new_attribute, $query_attribute, $pattern) {
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=".DBHOST."; dbname=".DBNAME,
            DBUSER,
            DBPASS
        );

        $statement = $db -> prepare(
            "UPDATE $table " .
            "SET $current_attribute = :new_attribute " .
            "WHERE $query_attribute = :pattern"
        );

        $statement -> execute(
            array('new_attribute' => $new_attribute, 'pattern' => $pattern)
        );

        $statement = null;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>updateAttribute</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

/**
 * Deletes an entry from a $table where a $query matches $attribute. For
 * example, if I wanted to delete a user whose username was “guitarist” from a
 * table called user, I would use this function as follows:
 *
 *    delete("user", "username", "guitarist");
 *
 * @param $table     The table holding the query to delete
 * @param $attribute The field whose query I want to match for deletion
 * @param $query     The entry I care to delete
 *
 * @access public
 * @return void
 */
function delete($table, $attribute, $query) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME,
            DBUSER,
            DBPASS);

        $statement = $db ->
            prepare("DELETE FROM $table WHERE $attribute = :query");
        $statement -> execute(array('query' => $query));
        $statement = null;
    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>delete</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

/**
 * Prints each $attribute associated with a $table. For example, if I wanted to
 * print every album name in an “album” database, I would use this function as
 * follows:
 *
 *    printAttributesFromTable("album_name", "album");
 *
 * @param $attribute  The attribute whose values I’d like to print
 * @param $table      The table to which the attribute belongs
 *
 * @access public
 * @return void
 */
function printAttributesFromTable($attribute, $table) {
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
            DBUSER,
            DBPASS
        );

        $statement = $db -> prepare("SELECT '$attribute' FROM $table");
        $statement -> execute();

        while($row = $statement -> fetch(PDO::FETCH_NUM)) {
            echo "<li>$row[0]</li>\n";
        }

        $statement = null;

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function " .
            "<code>printAttributesFromTable</code> has generated the " .
            "following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function createNewEntry($table_1, $website_URL, $website_name, $table_2, $first_name, $last_name, $username, $email, $p_word, $_comment) {
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
            DBUSER,
            DBPASS
        );

        $statement = $db -> prepare("INSERT INTO $table_1 VALUES ('$website_URL', '$website_name')");
        $statement -> execute();
        $statement = null;

        $statement = $db -> prepare("INSERT INTO $table_2 VALUES ('$website_URL', '$first_name', '$last_name', '$username', '$email', '$p_word', '$comment')");
        $statement -> execute();
        $statement = null;

        

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function " .
            "<code>printAttributesFromTable</code> has generated the " .
            "following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function resetDatabase() {
    include_once "config.php";

    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
        DBUSER,
        DBPASS
    );
    
    $statement = $db -> prepare("DROP TABLE IF EXISTS websites");
    $statement -> execute();
    $statement = null;

    $statement = $db -> prepare("DROP TABLE IF EXISTS account");
    $statement -> execute();
    $statement = null;

    $statement = $db -> prepare("CREATE TABLE websites (
        website_name VARCHAR(128) NOT NULL,
        website_URL VARCHAR(128) NOT NULL,
        PRIMARY KEY (website_URL))");
    $statement -> execute();
    $statement = null;

    $statement = $db -> prepare("CREATE TABLE account (
        website_URL VARCHAR(128) NOT NULL,
        first_name VARCHAR(64) NOT NULL,
        last_name VARCHAR(64) NOT NULL,
        username VARCHAR(64) NOT NULL,
        email VARCHAR(128) NOT NULL,
        p_word VARCHAR(128) NOT NULL,
        PRIMARY KEY (website_URL, username, p_word))");
    $statement -> execute();
    $statement = null;

    $statement = $db -> prepare("INSERT INTO websites VALUES
        ('Youtube', 'https://www.youtube.com/'),
        ('Google', 'https://www.google.com/'),
        ('Facebook', 'https://www.facebook.com/'),
        ('Yahoo', 'https://www.yahoo.com/'),
        ('Amazon', 'https://www.amazon.com/'),
        ('Reddit', 'https://www.reddit.com/'),
        ('Ebay', 'https://www.ebay.com/'),
        ('Twitter', 'https://twitter.com/'),
        ('LinkedIn', 'https://www.linkedin.com/'),
        ('Pinterest', 'https://www.pinterest.com/')");
    $statement -> execute();
    $statement = null;

    $statement = $db -> prepare("INSERT INTO account VALUES
        ('https://www.youtube.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'youtubePass'),
        ('https://www.google.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'googlePass'),
        ('https://www.facebook.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'facebookPass'),
        ('https://www.yahoo.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'yahooPass'),
        ('https://www.amazon.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'amazonPass'),
        ('https://www.reddit.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'redditPass'),
        ('https://www.ebay.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'ebayPass'),
        ('https://twitter.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'twitterPass'),
        ('https://www.linkedin.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'linkedinPass'),
        ('https://www.pinterest.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'pinterestPass');");
    $statement -> execute();
    $statement = null;
}

?>