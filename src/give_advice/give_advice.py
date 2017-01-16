#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys

def get_advice(calorie, protein, lipid, carbo):
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
	
	target_calorie = 883.0
	calorie_ratio  = calorie/target_calorie
	
	target_protein = 80.0
	protein_ratio  = protein/target_protein
	
	target_lipid   = 222.0
	lipid_ratio    = lipid/target_lipid
	
	target_carbo   = 441.0
	carbo_ratio    = carbo/target_carbo
	
	advice = u""
	if calorie > target_calorie:
		advice = u"カロリーが推奨量の%.2f倍と多めです。食べ過ぎに気をつけましょう。\n" % (calorie_ratio)
	elif calorie < target_calorie * 0.8:
		advice = u"カロリーが推奨量の%.2f倍と少なめです。\n"  % (calorie_ratio)
	
	if protein > target_protein:
		advice += u"蛋白質が推奨量の%.2f倍と多めです。肉や魚、大豆製品などの摂り過ぎに気をつけましょう。\n" % (protein_ratio)
	elif protein < target_protein * 0.8:
		advice += u"蛋白質が推奨量の%.2f倍と少なめです。肉や魚、大豆製品などから蛋白質を取るようにしましょう。\n" % (protein_ratio)
	
	if lipid > target_lipid:
		advice += u"""脂質が推奨量の%.2f倍です。肉の脂身、揚げ物、クリームを使った洋菓子などには
		             脂質が多く含まれるので控えめにしましょう。\n""" % (lipid_ratio)
	elif lipid < target_lipid * 0.8:
		advice += u"脂質が推奨量の%.2f倍と少なめです。乳製品などから脂質を取るようにしましょう。\n" % (lipid_ratio)
	
	if carbo > target_carbo:
		advice += u"炭水化物が推奨量の%.2f倍と多めです。お米、パン、麺類、いも類、お菓子や砂糖を控えめにしましょう。\n" % (carbo_ratio)
	elif carbo < target_carbo * 0.8:
		advice += u"炭水化物が推奨量の%.2f倍と少なめです。お米、パン、麺類、いも類などから炭水化物を取るようにしましょう。\n" % (carbo_ratio)
	
	return advice
	
if __name__ == '__main__':
	args = sys.argv
	advice = get_advice(calorie=float(args[1]), protein=float(args[2]), lipid=float(args[3]), carbo=float(args[4]))
	print(advice)
