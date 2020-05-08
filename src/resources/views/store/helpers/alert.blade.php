  <!-- alert success start -->
  @if (session('success'))
  <div id="alert-divv">
      <div class="row">
          <div class="col-10">
              <p id="alert-msg">{{ session('success') }}</p>
          </div>
          <div class="col-2">
              <button type="button" id="close-alert">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
      </div>
  </div>
  @endif
  <!-- alert success start -->
  <!-- alert warning start -->
  @if (session('warning'))
  <div id="alert-divv">
      <div class="row">
          <div class="col-10">
              <p id="alert-msg">{{ session('warning') }}</p>
          </div>
          <div class="col-2">
              <button type="button" id="close-alert">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
      </div>
  </div>
  @endif
  <!-- alert warning end -->