#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys

def get_advice(food_id):
	"""
	:type calorie: float
	:param calorie: amount of calorie per one meal (kcal)
	
	:type protein: float
	:param protein: amount of protein per one meal (kcal)
	
	:type lipid: float
	:param lipid: amount of lipid per one meal (kcal)
	
	:type carbo: float
	:param carbo: amount of carbohydrate per one meal (kcal)
	"""
	food = u""
	if(food_id==0):   # sandwich
	    calorie, protein, lipid, carbo, food = 535.0, 80.0, 224.0, 228.0, u"サンドイッチ"
	elif(food_id==1): # cheese cake
	    calorie, protein, lipid, carbo, food = 315.0, 22.0, 219.0, 68.0, u"チーズケーキ"
	elif(food_id==2): # carbonara
	    calorie, protein, lipid, carbo, food = 779.0, 105.0, 355.0, 290.0, u"スパゲッティ（カルボナーラ）"
	elif(food_id==3): # bolognese
	    calorie, protein, lipid, carbo, food = 623.0, 98.0, 148.0, 340.0, u"スパゲッティ（ボロネーゼ）"
	elif(food_id==4): # rice_fried
	    calorie, protein, lipid, carbo, food = 637.0, 62.0, 189.0, 400.0, u"チャーハン"
	elif(food_id==5): # risotto
	    calorie, protein, lipid, carbo, food = 416.0, 39.0, 200.0, 160.0, u"リゾット"	
	if(food_id==6): # sushi
	    calorie, protein, lipid, carbo, food = 588.0, 141.0, 88.0, 343.0, u"すし"
	if(food_id==7): # soup_miso
	    calorie, protein, lipid, carbo, food = 20.0, 7.0, 4.0, 13.0, u"味噌汁"
	
	target_calorie = 883.0
	calorie_ratio  = calorie/target_calorie
	
	target_protein = 80.0
	protein_ratio  = protein/target_protein
	
	target_lipid   = 222.0
	lipid_ratio    = lipid/target_lipid
	
	target_carbo   = 441.0
	carbo_ratio    = carbo/target_carbo
	
	advice = food + u"ですね。\n"
	if calorie > target_calorie:
		advice += u"カロリーが推奨量の%.2f倍と多めです。食べ過ぎに気をつけましょう。\n" % (calorie_ratio)
	elif calorie < target_calorie * 0.8:
		advice += u"カロリーが推奨量の%.2f倍と少なめです。\n"  % (calorie_ratio)
	
	if protein > target_protein:
		advice += u"蛋白質が推奨量の%.2f倍と多めです。肉や魚、大豆製品などの摂り過ぎに気をつけましょう。\n" % (protein_ratio)
	elif protein < target_protein * 0.8:
		advice += u"蛋白質が推奨量の%.2f倍と少なめです。肉や魚、大豆製品などから蛋白質を取るようにしましょう。\n" % (protein_ratio)
	
	if lipid > target_lipid:
		advice += u"""脂質が推奨量の%.2f倍です。肉の脂身、揚げ物、クリームを使った洋菓子などには脂質が多く含まれるので控えめにしましょう。\n""" % (lipid_ratio)
	elif lipid < target_lipid * 0.8:
		advice += u"脂質が推奨量の%.2f倍と少なめです。乳製品などから脂質を取るようにしましょう。\n" % (lipid_ratio)
	
	if carbo > target_carbo:
		advice += u"炭水化物が推奨量の%.2f倍と多めです。お米、パン、麺類、いも類、お菓子や砂糖を控えめにしましょう。\n" % (carbo_ratio)
	elif carbo < target_carbo * 0.8:
		advice += u"炭水化物が推奨量の%.2f倍と少なめです。お米、パン、麺類、いも類などから炭水化物を取るようにしましょう。\n" % (carbo_ratio)
	
	return advice
	
if __name__ == '__main__':
	args = sys.argv
	advice = get_advice(food_id=int(args[1]))
	print(advice)
