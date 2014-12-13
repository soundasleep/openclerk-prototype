module.exports = (grunt) ->
  grunt.initConfig
    pkg: grunt.file.readJSON('package.json')

    clean:
      tmp: ['site/generated']

    bgShell:
      # TODO add a grunt npm task to wrap this
      assetDiscovery:
        cmd: 'php -f vendor/soundasleep/asset-discovery/generate.php -- .'
        fail: true

      # TODO add a grunt npm task to wrap this
      componentDiscovery:
        cmd: 'php -f vendor/soundasleep/component-discovery/generate.php -- .'
        fail: true

    sass:
      dist:
        files: [{
          expand: true
          cwd: 'site/generated/css'
          src: ['*.scss']
          dest: 'site/generated/css'
          ext: '.css'
        }]

    coffee:
      dist:
        files: [{
          expand: true
          cwd: 'site/generated/js'
          src: ['*.coffee']
          dest: 'site/generated/js'
          ext: '.js'
        }]

  grunt.loadNpmTasks 'grunt-bg-shell'
  grunt.loadNpmTasks 'grunt-contrib-clean'
  grunt.loadNpmTasks 'grunt-contrib-coffee'
  grunt.loadNpmTasks 'grunt-contrib-sass'

  grunt.registerTask 'default', "Generate static sites and assets and discover components", [
    'clean',
    'bgShell:assetDiscovery',
    'bgShell:componentDiscovery',
    'sass',
    'coffee'
  ]

