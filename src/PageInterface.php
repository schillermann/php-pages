<?php

namespace PhpPages;

interface PageInterface
{
    const OUTPUT_STATUS = 'PhpPages-Status';
    /**
     * HTTP response status codes
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const OUTPUT_STATUS_100_CONTINUE = 'HTTP/1.1 100 Continue';
    const OUTPUT_STATUS_101_SWITCHING_PROTOCOLS = 'HTTP/1.1 101 Switching Protocols';
    const OUTPUT_STATUS_102_PROCESSING_WEBDAV = 'HTTP/1.1 102 Processing';
    const OUTPUT_STATUS_103_EARLY_HINTS = 'HTTP/1.1 103 Early Hints';
    const OUTPUT_STATUS_200_OK = 'HTTP/1.1 200 OK';
    const OUTPUT_STATUS_201_CREATED = 'HTTP/1.1 201 Created';
    const OUTPUT_STATUS_202_ACCEPTED = 'HTTP/1.1 202 Accepted';
    const OUTPUT_STATUS_203_NON_AUTHORITATIVE_INFORMATION = 'HTTP/1.1 203 Non-Authoritative Information';
    const OUTPUT_STATUS_204_NO_CONTENT = 'HTTP/1.1 204 No Content';
    const OUTPUT_STATUS_205_RESET_CONTENT = 'HTTP/1.1 205 Reset Content';
    const OUTPUT_STATUS_206_PARTIAL_CONTENT = 'HTTP/1.1 206 Partial Content';
    const OUTPUT_STATUS_207_MULTI_STATUS_WEBDAV = 'HTTP/1.1 207 Multi-Status';
    const OUTPUT_STATUS_208_ALREADY_REPORTED_WEBDAV = 'HTTP/1.1 208 Already Reported';
    const OUTPUT_STATUS_226_IM_USED = 'HTTP/1.1 226 IM Used';
    const OUTPUT_STATUS_300_MULTIPLE_CHOICES = 'HTTP/1.1 300 Multiple Choices';
    const OUTPUT_STATUS_301_MOVED_PERMANENTLY = 'HTTP/1.1 301 Moved Permanently';
    const OUTPUT_STATUS_302_FOUND = 'HTTP/1.1 302 Found';
    const OUTPUT_STATUS_303_SEE_OTHER = 'HTTP/1.1 303 See Other';
    const OUTPUT_STATUS_304_NOT_MODIFIED = 'HTTP/1.1 304 Not Modified';
    const OUTPUT_STATUS_305_USE_PROXY = 'HTTP/1.1 305 Use Proxy';
    const OUTPUT_STATUS_306_UNUSED = 'HTTP/1.1 306 unused';
    const OUTPUT_STATUS_307_TEMPORARY_REDIRECT = 'HTTP/1.1 307 Temporary Redirect';
    const OUTPUT_STATUS_308_PERMANENT_REDIRECT = 'HTTP/1.1 308 Permanent Redirect';
    const OUTPUT_STATUS_400_BAD_REQUEST = 'HTTP/1.1 400 Bad Request';
    const OUTPUT_STATUS_401_UNAUTHORIZED = 'HTTP/1.1 401 Unauthorized';
    const OUTPUT_STATUS_402_PAYMENT_REQUIRED = 'HTTP/1.1 402 Payment Required';
    const OUTPUT_STATUS_403_FORBIDDEN = 'HTTP/1.1 403 Forbidden';
    const OUTPUT_STATUS_404_NOT_FOUND = 'HTTP/1.1 404 Not Found';
    const OUTPUT_STATUS_405_METHOD_NOT_ALLOWED = 'HTTP/1.1 405 Method Not Allowed';
    const OUTPUT_STATUS_406_NOT_ACCEPTABLE = 'HTTP/1.1 406 Not Acceptable';
    const OUTPUT_STATUS_407_PROXY_AUTHENTICATION_REQUIRED = 'HTTP/1.1 407 Proxy Authentication Required';
    const OUTPUT_STATUS_408_REQUEST_TIMEOUT = 'HTTP/1.1 408 Request Timeout';
    const OUTPUT_STATUS_409_CONFLICT = 'HTTP/1.1 409 Conflict';
    const OUTPUT_STATUS_410_GONE = 'HTTP/1.1 410 Gone';
    const OUTPUT_STATUS_411_LENGTH_REQUIRED = 'HTTP/1.1 411 Length Required';
    const OUTPUT_STATUS_412_PRECONDITION_FAILED = 'HTTP/1.1 412 Precondition Failed';
    const OUTPUT_STATUS_413_PAYLOAD_TOO_LARGE = 'HTTP/1.1 413 Payload Too Large';
    const OUTPUT_STATUS_414_URI_TOO_LONG = 'HTTP/1.1 414 URI Too Long';
    const OUTPUT_STATUS_415_UNSUPPORTED_MEDIA_TYPE = 'HTTP/1.1 415 Unsupported Media Type';
    const OUTPUT_STATUS_416_RANGE_NOT_SATISFIABLE = 'HTTP/1.1 416 Range Not Satisfiable';
    const OUTPUT_STATUS_417_EXPECTATION_FAILED = 'HTTP/1.1 417 Expectation Failed';
    const OUTPUT_STATUS_418_IM_A_TEAPOT = 'HTTP/1.1 418 I\'m a teapot';
    const OUTPUT_STATUS_421_MISDIRECTED_REQUEST = 'HTTP/1.1 421 Misdirected Request';
    const OUTPUT_STATUS_422_UNPROCESSABLE_CONTENT_WEBDAV = 'HTTP/1.1 422 Unprocessable Content';
    const OUTPUT_STATUS_423_LOCKED_WEBDAV = 'HTTP/1.1 423 Locked';
    const OUTPUT_STATUS_424_FAILED_DEPENDENCY_WEBDAV = 'HTTP/1.1 424 Failed Dependency';
    const OUTPUT_STATUS_425_TOO_EARLY = 'HTTP/1.1 425 Too Early';
    const OUTPUT_STATUS_426_UPGRADE_REQUIRED = 'HTTP/1.1 426 Upgrade Required';
    const OUTPUT_STATUS_428_PRECONDITION_REQUIRED = 'HTTP/1.1 428 Precondition Required';
    const OUTPUT_STATUS_429_TOO_MANY_REQUESTS = 'HTTP/1.1 429 Too Many Requests';
    const OUTPUT_STATUS_431_REQUEST_HEADER_FIELDS_TOO_LARGE = 'HTTP/1.1 431 Request Header Fields Too Large';
    const OUTPUT_STATUS_451_UNAVAILABLE_FOR_LEGAL_REASONS = 'HTTP/1.1 451 Unavailable For Legal Reasons';
    const OUTPUT_STATUS_500_INTERNAL_SERVER_ERROR = 'HTTP/1.1 500 Internal Server Error';
    const OUTPUT_STATUS_501_NOT_IMPLEMENTED = 'HTTP/1.1 501 Not Implemented';
    const OUTPUT_STATUS_502_BAD_GATEWAY = 'HTTP/1.1 502 Bad Gateway';
    const OUTPUT_STATUS_503_SERVICE_UNAVAILABLE = 'HTTP/1.1 503 Service Unavailable';
    const OUTPUT_STATUS_504_GATEWAY_TIMEOUT = 'HTTP/1.1 504 Gateway Timeout';
    const OUTPUT_STATUS_505_HTTP_VERSION_NOT_SUPPORTED = 'HTTP/1.1 505 HTTP Version Not Supported';
    const OUTPUT_STATUS_506_VARIANT_ALSO_NEGOTIATES = 'HTTP/1.1 506 Variant Also Negotiates';
    const OUTPUT_STATUS_507_INSUFFICIENT_STORAGE_WEBDAV = 'HTTP/1.1 507 Insufficient Storage';
    const OUTPUT_STATUS_508_LOOP_DETECTED_WEBDAV = 'HTTP/1.1 508 Loop Detected';
    const OUTPUT_STATUS_510_NOT_EXTENDED = 'HTTP/1.1 510 Not Extended';
    const OUTPUT_STATUS_511_NETWORK_AUTHENTICATION_REQUIRED = 'HTTP/1.1 511 Network Authentication Required';

    const METADATA_PROTOCOL = 'PhpPages-Protocol';
    const METADATA_METHOD = 'PhpPages-Method';
    const METADATA_PATH = 'PhpPages-Path';
    const METADATA_QUERY = 'PhpPages-Query';
    const METADATA_BODY = 'PhpPages-Body';

    function viaOutput(OutputInterface $output): OutputInterface;

    function withMetadata(string $name, string $value): PageInterface;
}
