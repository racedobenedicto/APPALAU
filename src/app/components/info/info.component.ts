import { Component, Input, OnInit } from '@angular/core';
import { Article } from 'src/app/interfaces/interface';

@Component({
  selector: 'app-info',
  templateUrl: './info.component.html',
  styleUrls: ['./info.component.scss'],
})
export class InfoComponent implements OnInit {

  @Input() info: Article;

  constructor() { }

  ngOnInit() {}

}
