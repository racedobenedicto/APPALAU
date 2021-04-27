import { Component, Input, OnInit } from '@angular/core';
import { Msg } from 'src/app/interfaces/interface';

@Component({
  selector: 'app-message',
  templateUrl: './message.component.html',
  styleUrls: ['./message.component.scss'],
})
export class MessageComponent implements OnInit {

  @Input() messages: Msg[] = [];
  @Input() colors: string[] = [];

  constructor() { }

  ngOnInit() {
  }
}
