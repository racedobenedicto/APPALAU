import { Component, Input, OnInit } from '@angular/core';
import { Msg } from '../../interfaces/interface';
import { GlobalVar } from '../../services/GlobalVar';


@Component({
  selector: 'app-msg',
  templateUrl: './msg.component.html',
  styleUrls: ['./msg.component.scss'],
})
export class MsgComponent implements OnInit {

  @Input() msg: Msg;

  constructor(public global: GlobalVar) { }

  ngOnInit() {}

}
