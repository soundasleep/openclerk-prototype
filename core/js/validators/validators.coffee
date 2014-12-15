
class OpenclerkForms.Validators.RequiredValidator
  constructor: (@message) ->

  invalid: (data, form) ->
    if !(data != null && data.length > 0)
      return [@message]

class OpenclerkForms.Validators.MaxLengthValidator
  constructor: (@number, @message) ->

  invalid: (data, form) ->
    if data != null && !(data.length <= @number)
      return [@message]

class OpenclerkForms.Validators.MinLengthValidator
  constructor: (@number, @message) ->

  invalid: (data, form) ->
    if data != null && !(data.length >= @number)
      return [@message]

class OpenclerkForms.Validators.EqualsValidator
  constructor: (@key, @message) ->

  invalid: (data, form) ->
    field = form[@key]
    e = $("#" + field['id'])

    if !(e.val() == data)
      return [@message]

class OpenclerkForms.Validators.EmailValidator
  constructor: (@message) ->

  invalid: (data, form) ->
    if data != null && !(/^[^@ ]+@([^@ ]+\.)+[^@ ]+$/.test(data))
      return [@message]
