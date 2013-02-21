<?php
include '../common/class.Database.php';
class quotesheetClient extends Database
{
    function clientView()
    {
        $hasrelentries=$_GET['hasrelated'];
        if($hasrelentries=="Y")
        {
            $query="SELECT cli_Code,name FROM `jos_users` where cli_Type=5 order by name";
            $result=mysql_query($query);
            ?>
            <select name="allclients[]"  multiple >
                <?php while($row=mysql_fetch_array($result)) { ?>
                <option value="<?php echo $row['cli_Code']?>" <?php  echo $this->makeSelect($row['cli_Code'],$_GET['cardfilecode']);?>><?php echo $row['name']?></option>
                 <?php } ?>
            </select>
             <?php
        }
    }
    function makeSelect($cli_Code,$cardfilecode)
    {
        if(isset($cardfilecode) && $cardfilecode!="")
        {
            $query2="SELECT * from  `cde_qcardfiledetails` where cde_ClientCode=".$cli_Code." AND cde_CardFileCode=".$cardfilecode;
            $result2=mysql_query($query2);
            if(mysql_num_rows($result2)>0)
            {
                $selected="selected";
            }
        }
        return $selected;
    }
}
$viewClient = new quotesheetClient();
$viewClient->clientView();
?>