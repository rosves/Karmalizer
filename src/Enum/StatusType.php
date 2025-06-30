<?php
namespace App\Enum;

enum StatusType : string {
  case Pending = 'Pending';
  case Validated = 'Validated';
  case Rejected = 'Rejected';
}
