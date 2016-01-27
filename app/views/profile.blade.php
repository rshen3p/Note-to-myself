@extends('master')

@section('nameOfPage', 'Notes')
<style>
    h1 {
        text-align: center;
    }
</style>

@section('content')
    <h1><?php echo $userProfile[0]['email'];?> - <a href="logout">Log Out</a></h1>
    <form action="submitPage" method="POST" enctype="multipart/form-data">
        <div clas="row">
            <div class="col-md-3">
                <div class="form-group">
                    <h1>Notes</h1>
                    <textarea class="form-control" name="notes" rows="25" id="comment"><?php
                        if($userProfile[0]['notes'] != "")
                            echo $userProfile[0]['notes'];
                        ?>
                    </textarea>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <h1>Links</h1>
                    <?php
                        $websiteArray;
                        $i = 0;

                        if(isset($userProfile["websites"])){
                            $websiteArray = $userProfile["websites"];
                            for(; $i < count($websiteArray); $i++){
                                if($websiteArray[$i] != "")
                                    echo "<a href=\"$websiteArray[$i]\">
                                            <input type='text' name=\"website$i\" value=\"$websiteArray[$i]\">
                                        </a>";
                            }
                            echo "<input type='text' name=\"website$i\">";
                            $i++;
                            echo "<input type='text' name=\"website$i\">";
                        }

                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <h1>Images</h1>
                    <input type="file" name="photo" id="photo">
                    <?php
                        $imageArray;
                        $i = 0;
                        //var_dump($userProfile);
                        if(isset($userProfile["image"])){
                            $imageArray = $userProfile["image"];
                            for($i = 0,$temp = 0; $i < count($imageArray); $i++,$temp++){
                                if($imageArray[$i] != ""){
                                    echo '<img width=150 height=150 src="data:image/jpeg;base64,'.base64_encode($imageArray[$i]).'"/>';
                                    echo "<input type='checkbox' name=\"delete$temp\">delete<br>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <h1>TBD</h1>
                    <textarea class="form-control" name="tbd" rows="25" id="comment"><?php
                        echo $userProfile[0]['tbd'];
                        ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-default">Submit</button>
                <input type="hidden" name="userID" value="<?php echo $userProfile[0]['userID'];?>"/>
            </div>
        </div>
    </form>
@endsection