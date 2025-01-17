<?php

declare(strict_types=1);

namespace OpenTelemetry\Tracing;

class Status
{
    const OK = 0;
    const CANCELLED = 1;
    const UNKNOWN = 2;
    const INVALID_ARGUMENT = 3;
    const DEADLINE_EXCEEDED = 4;
    const NOT_FOUND = 5;
    const ALREADY_EXISTS = 6;
    const PERMISSION_DENIED = 7;
    const RESOURCE_EXHAUSTED = 8;
    const FAILED_PRECONDITION = 9;
    const ABORTED = 10;
    const OUT_OF_RANGE = 11;
    const UNIMPLEMENTED = 12;
    const INTERNAL = 13;
    const UNAVAILABLE = 14;
    const DATA_LOSS = 15;
    const UNAUTHENTICATED = 16;

    const DESCRIPTION = [
        0 => 'Not an error; returned on success.',
        1 => 'The operation was cancelled, typically by the caller.',
        2 => 'Unknown error. For example, this error may be returned when a Status value received from another address space belongs to an error space that is not known in this address space. Also errors raised by APIs that do not return enough error information may be converted to this error.',
        3 => 'The client specified an invalid argument. Note that this differs from FAILED_PRECONDITION. INVALID_ARGUMENT indicates arguments that are problematic regardless of the state of the system (e.g., a malformed file name).',
        4 => 'The deadline expired before the operation could complete. For operations that change the state of the system, this error may be returned even if the operation has completed successfully. For example, a successful response from a server could have been delayed long',
        5 => 'Some requested entity (e.g., file or directory) was not found. Note to server developers: if a request is denied for an entire class of users, such as gradual feature rollout or undocumented whitelist, NOT_FOUND may be used. If a request is denied for some users within a class of users, such as user-based access control, PERMISSION_DENIED must be used.',
        6 => 'The entity that a client attempted to create (e.g., file or directory) already exists.',
        7 => 'The caller does not have permission to execute the specified operation. PERMISSION_DENIED must not be used for rejections caused by exhausting some resource (use RESOURCE_EXHAUSTED instead for those errors). PERMISSION_DENIED must not be used if the caller can not be identified (use UNAUTHENTICATED instead for those errors). This error code does not imply the request is valid or the requested entity exists or satisfies other pre-conditions.',
        8 => 'Some resource has been exhausted, perhaps a per-user quota, or perhaps the entire file system is out of space.',
        9 => 'The operation was rejected because the system is not in a state required for the operation\'s execution. For example, the directory to be deleted is non-empty, an rmdir operation is applied to a non-directory, etc. Service implementors can use the following guidelines to decide between FAILED_PRECONDITION, ABORTED, and UNAVAILABLE: (a) Use UNAVAILABLE if the client can retry just the failing call. (b) Use ABORTED if the client should retry at a higher level (e.g., when a client-specified test-and-set fails, indicating the client should restart a read-modify-write sequence). (c) Use FAILED_PRECONDITION if the client should not retry until the system state has been explicitly fixed. E.g., if an "rmdir" fails because the directory is non-empty, FAILED_PRECONDITION should be returned since the client should not retry unless the files are deleted from the directory.',
        10 => 'The operation was aborted, typically due to a concurrency issue such as a sequencer check failure or transaction abort. See the guidelines above for deciding between FAILED_PRECONDITION, ABORTED, and UNAVAILABLE.',
        11 => 'The operation was attempted past the valid range. E.g., seeking or reading past end-of-file. Unlike INVALID_ARGUMENT, this error indicates a problem that may be fixed if the system state changes. For example, a 32-bit file system will generate INVALID_ARGUMENT if asked to read at an offset that is not in the range [0,2^32-1], but it will generate OUT_OF_RANGE if asked to read from an offset past the current file size. There is a fair bit of overlap between FAILED_PRECONDITION and OUT_OF_RANGE. We recommend using OUT_OF_RANGE (the more specific error) when it applies so that callers who are iterating through a space can easily look for an OUT_OF_RANGE error to detect when they are done.',
        12 => 'The operation is not implemented or is not supported/enabled in this service.',
        13 => 'Internal errors. This means that some invariants expected by the underlying system have been broken. This error code is reserved for serious errors.',
        14 => 'The service is currently unavailable. This is most likely a transient condition, which can be corrected by retrying with a backoff. Note that it is not always safe to retry non-idempotent operations.',
        15 => 'Unrecoverable data loss or corruption.',
        16 => 'The request does not have valid authentication credentials for the operation.',
    ];

    private $code;
    private $description;
    static private $ok;

    public function __construct(int $code, string $description = null)
    {
        $this->code = $code;
        if (!$description && array_key_exists($code, self::DESCRIPTION)) {
            $description = self::DESCRIPTION[$code];
        }
        if (!is_null($description)) {
            $this->description = $description;
        }
    }

    public static function new(int $code, string $description = null) {
        if ($code === self::OK && ($description === null || $description == self::DESCRIPTION[self::OK])) {
            return self::$ok;
        }
        return new Status($code, $description);
    }

    public static function initOk() {
        if (!self::$ok) {
            self::$ok = new Status(self::OK);
        }
    }

    public function getCanonicalCode() : int
    {
        return $this->code;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function getIsOk() : bool
    {
        return $this->code == self::OK;
    }
}

Status::initOk();