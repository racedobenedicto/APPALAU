import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-header-edit',
  templateUrl: './header-edit.component.html',
  styleUrls: ['./header-edit.component.scss'],
})
export class HeaderEditComponent implements OnInit {

  constructor( private modalController: ModalController ) { }

  ngOnInit() {}

  closeEdit() {
    this.modalController.dismiss();
  }

}
