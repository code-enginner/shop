/*
*** Get Dom Element
* */
var get = get || {};
get._id = function (elm)
{
    return document.getElementById(elm);
};
get._class = function (elm)
{
    return document.getElementsByClassName(elm);
};
get._tag = function (elm)
{
    return document.getElementsByTagName(elm);
};
get._name = function (elm)
{
    return document.getElementsByName(elm);
};


/*
*** Ajax Handle
* */

function Request (data, output, responseMode, loading)
{
    /*** variables defining ***/
    var _xmlHttp, _output, _result, _responseMode, _loading;

    this._values = data._values;
    this._values = JSON.stringify(this._values);
    this._method = data._method.toUpperCase() || 'POST';
    this._fileSystem = data._fileSystem;
    this._async = data._async || true;
    this._headerMode_1 = data._headerMode_1 || 'Content-type';
    this._headerMode_2 = data._headerMode_2 || 'application/x-www-form-urlencoded';
    _loading = loading || null;
    _responseMode = responseMode;
    _output = output;

    /*** xmlHttp defining ***/
    _xmlHttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    /*** check data ***/
    this.checkData = function ()
    {
        console.log('values: ' + this._values);
        console.log('method: ' + this._method);
        console.log('fileSystem: ' + this._fileSystem);
        console.log('async: ' + this._async);
        console.log('headerMode_1: ' + this._headerMode_1);
        console.log('headerMode_2: ' + this._headerMode_2);
        console.log('loading: ' + _loading);
        console.log('responseMode: ' + _responseMode);
        console.log('output: ' + _output);
    };

    /*** methods defining ***/
    this.call = function ()
    {
        if (this._async === true)
        {
            _xmlHttp.onreadystatechange = function ()
            {
                if (_responseMode === 'text')
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        _result = _xmlHttp.responseText;
                        _output.innerHTML = _result;
                    }
                }

                if (_responseMode === 'xml')
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        _result = _xmlHttp.responseXML;
                        _output.innerHTML = _result;
                    }
                }

            };

            if (this._method === 'POST')
            {
                _xmlHttp.open(this._method, this._fileSystem, this._async);
                _xmlHttp.setRequestHeader(this._headerMode_1, this._headerMode_2);
                _xmlHttp.send(this._values);
            }

            if (this._method === 'GET')
            {
                _xmlHttp.open(this._method, this._fileSystem + this._values, this._async);
                _xmlHttp.send(null);
            }
        }

        if (this._async === false)
        {
            if (this._method === 'POST')
            {
                _xmlHttp.open(this._method, this._fileSystem, this._async);
//                   _xmlHttp.setRequestHeader(this._headerMode_1, this._headerMode_2);
                _xmlHttp.send(this._values);

                if (_responseMode === 'text')
                {
                    _result = this.responseText;
                    _output.innerHTML = _result;
                }

                if (_responseMode === 'xml')
                {
                    _result = this.responseXML;
                    _output.innerHTML = _result;
                }
            }

            if (this._method === 'GET')
            {
                _xmlHttp.open(this._method, this._fileSystem + this._values, this._async);
                _xmlHttp.send(null);

                if (_responseMode === 'text')
                {
                    _result = this.responseText;
                    _output.innerHTML = _result;
                }

                if (_responseMode === 'xml')
                {
                    _result = this.responseXML;
                    _output.innerHTML = _result;
                }
            }
        }
    }
}