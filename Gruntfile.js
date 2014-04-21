module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        modernizr: {
            dist: {
                "devFile" : "remote", // minified dev
                "outputFile" : "public/js/modernizr.min.js", // minified prod

                "extra" : {
                    "shiv" : true,
                    "printshiv" : false,
                    "load" : true,
                    "mq" : false,
                    "cssclasses" : true,
                    "inputtypes" : true
                },

                "extensibility" : {
                    "addtest" : false,
                    "prefixed" : false,
                    "teststyles" : false,
                    "testprops" : false,
                    "testallprops" : false,
                    "hasevents" : false,
                    "prefixes" : false,
                    "domprefixes" : false
                },

                "uglify" : true,
                "tests" : [],

                // By default, this task will crawl your project for references to Modernizr tests.
                // Set to false to disable.
                "parseFiles" : true,

                // When parseFiles = true, this task will crawl all *.js, *.css, *.scss files, except files that are in node_modules/.
                // You can override this by defining a "files" array below.
                "files" : {
                    "src": []
                },

                // When parseFiles = true, matchCommunityTests = true will attempt to
                // match user-contributed tests.
                "matchCommunityTests" : false,

                // Have custom Modernizr tests? Add paths to their location here.
                "customTests" : []
            }
        }
    });
    
    grunt.loadNpmTasks("grunt-modernizr");
};
