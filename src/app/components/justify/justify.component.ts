import { Component, Input, OnInit } from '@angular/core';
import { PopoverController } from '@ionic/angular';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-justify',
  templateUrl: './justify.component.html',
  styleUrls: ['./justify.component.scss'],
})
export class JustifyComponent implements OnInit {

  @Input() dates: string[];
  @Input() justification = {
    date: '',
    text: ''
  }
  
  constructor( private popoverController: PopoverController ) { }

  ngOnInit() {}

  accept( form: NgForm ) {
    this.popoverController.dismiss({
      item: this.justification
    });
  }

  cancel() {
    this.popoverController.dismiss();
  }
}
