<!-- Get Started Modal -->
<div id="planner" class="modal hide fade" tabindex="-1" data-width="500">  
  <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>  
    <h3>Let's fill out your travel preferences...</h3>
  </div>  
  <div class="modal-body">
    <form name="plan" action="map.php" method="get">
      <fieldset>
        <h4>Activities/Environment</h4>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="snow" value="snow"> Ski/snowboarding
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="bike" value="bike"> Biking
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="hike" value="hike"> Hiking
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="golf" value="golf"> Golf
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="art" value="art"> Arts
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="prosport" value="prosport"> Professional Sports
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="beach" value="beach"> Beach
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="gamble" value="gamble"> Gambling
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="family" value="family"> Family
          </label>
          <label class="checkbox inline">
            <input type="checkbox" name="activitiesDoor[]" id="night" value="night"> Nightlife
          </label>
        <hr>
      <h4>Travel Dates</h4>
        Start: <input type="text" name="initDate" id="datepicker1" />
        <br>
        End: <input type="text" name="finalDate" id="datepicker2" />
        <br>
      <h4>Weather</h4>
        <label class="radio">
          <input type="radio" name="weatherRad" id="hot" value="1"/>
          Frigid (Below 0F)
        </label>
        <label class="radio">
          <input type="radio" name="weatherRad" id="cold" value="2"/>
          Cold (0-24F)
        </label>
        <label class="radio">
          <input type="radio" name="weatherRad" id="cool" value="3"/>
          Cool (25-49F)
        </label>
        <label class="radio">
          <input type="radio" name="weatherRad" id="warm" value="4"/>
          Warm (50-74F)
        </label>
        <label class="radio">
          <input type="radio" name="weatherRad" id="hot" value="5"/>
          Hot (75-95F)
        </label>
        <label class="radio">
          <input type="radio" name="weatherRad" id="hot" value="6"/>
          Blazing (Above 96F)
        </label>    
        </fieldset>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">See results!</button>
      <a href="#" class="btn btn-danger" data-dismiss="modal">Go Back</a>  
    </div>
    </form>
  </div>
</div>
