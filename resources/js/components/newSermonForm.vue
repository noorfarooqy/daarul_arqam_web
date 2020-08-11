<template>
  <form class="form" method="POST" enctype="multipart/form-data">
    <div class="alert alert-success" v-if="isSuccess">
      <span v-text="successMessage"></span>
    </div>

    <div class="alert alert-danger" v-if="hasError">
      <span v-text="errorMessage"></span>
    </div>

    <div class="mb-4">
      <select class="form-control" @change.prevent="setSelectedSheekh">
        <option value="-1">Sheekha soo jeediyay muxaadarada</option>
        <option
          :value="sheekh.id"
          v-for="(sheekh, skey) in sheekhList"
          :key="skey"
        >{{sheekh.sheekh_name}}</option>
      </select>
    </div>
    <div class="mb-4">
      <input
        class="form-control"
        name="cinwaanka_muxaadarada"
        type="text"
        placeholder="Cinwaanka Muxaadarada"
        v-model="sermonTitle"
      />
    </div>
    <div class="mb-4">
      <input
        class="form-control"
        name="goobga_muxaadara"
        type="text"
        placeholder="Goobta Muxaadarada lagu qabtay"
        v-model="sermonLocation"
      />
    </div>
    <div class="mb-4">
      <label for>Fileka muxaadarada</label>
      <input class="form-control" name="fileka_muxaadarada" id="fileka_muxaadarada" type="file" />
    </div>
    <div class="mb-4">
      <button
        class="form-control btn btn-primary"
        type="submit"
        :disabled="isLoading"
        @click.prevent="submitForm"
      >
        <span v-text="buttonText"></span>
        <span class="spinner-border text-white small" role="status" v-if="isLoading"></span>
      </button>
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      name: "new lesson form",
      version: 1,
      isLoading: false,
      buttonText: "Add Lesson",
      lessonNumber: 0,
      isSuccess: false,
      successMessage: null,
      hasError: false,
      errorMessage: null,
      sermonTitle: null,
      sheekhId: -1,
      sermonLocation: null
    };
  },
  mounted() {
    if (window.lessonNumber != undefined && window.lessonNumber != null) {
      console.log("I am " + window.lessonNumber);
      this.lessonNumber = window.lessonNumber;
      window.lessonNumber = parseInt(window.lessonNumber) + 1;
      this.Lesson.setCasharNumber(this.lessonNumber);
    }
  },
  methods: {
    resetMessages() {
      this.errorMessage = null;
      this.hasError = false;
      this.isSuccess = false;
      this.successMessage = null;
    },
    submitForm($event) {
      this.resetMessages();
      console.log("we are here ");
      this.buttonText = "Loading...";
      this.isLoading = true;
      var data = new FormData();
      data.append("api_token", window.api_token);
      data.append("cinwaanka_muxaadara", this.sermonTitle);
      data.append("goobta_muxaadarada", this.sermonLocation);
      data.append(
        "fileka_muxaadarada",
        document.getElementById("fileka_muxaadarada").files[0]
      );
      data.append("sheekha", this.sheekhId);
      console.log(data);
      var _this = this;
      var config = {
        onUploadProgress: function(progressEvent) {
          var percentCompleted = Math.round(
            (progressEvent.loaded * 100) / progressEvent.total
          );
          _this.buttonText = "loading... " + percentCompleted + "%";
        }
      };

      axios
        .post("/api/muxaadaro/new", data, config)
        .then(function(res) {
          if (res.data["isSuccess"] == false) {
            _this.errorMessage = JSON.stringify(res.data["errorMessage"]);
            _this.hasError = true;
            _this.isLoading = false;
            _this.buttonText = "Add Sermon";
          } else {
            _this.successMessage = "successfully completed muxaadarada";
            _this.isSuccess = true;
            _this.$emit("completed-sermon");
            _this.buttonText = "Add Sermon";
            _this.isLoading = false;
          }
        })
        .catch(function(err) {
          _this.errorMessage = err.message;
          _this.hasError = true;
          _this.isLoading = false;
          _this.buttonText = "Add Sermon";
        });
    },

    setSelectedSheekh(event) {
      console.log(event);
      var selectedIndex = event.target.selectedIndex;
      this.sheekhId = event.target.options[selectedIndex].value;
    }
  },
  props: ["sheekhList"]
};
</script>
